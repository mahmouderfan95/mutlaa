<?php
namespace App\Services\Admin;
use App\Models\Trip;
use App\Repositories\Eloquent\TripRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TripService
{
    public function __construct(
        protected TripRepository $repository,
        private readonly ImageService $imageService,
    ){}
    public function list(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage, $filters,['media']);
    }

    public function find(int $id): Trip
    {
        return $this->repository->findOrFail($id);
    }

    public function store(array $data): Trip
    {
        $attachments = $data['attachments'] ?? [];
        unset($data['attachments']);

        $uploadedImage = null;
        $uploadedMedia = [];

        try {
            if (isset($data['cover_image'])) {
                $uploadedImage = $this->imageService->store($data['cover_image'], 'trips');
                $data['cover_image'] = $uploadedImage;
            }

            if (!empty($attachments)) {
                $files = is_array($attachments) ? $attachments : [$attachments];
                $uploadedMedia = $this->imageService->storeMany($files, 'trips/media');
            }


            $trip = DB::transaction(function () use ($data, $uploadedMedia) {
                /** @var Trip $trip */
                $trip = $this->repository->create($data);

                if (!empty($uploadedMedia)) {
                    $trip->media()->createMany($uploadedMedia);
                }

                return $trip;
            });

            return $trip->load(['media']);

        } catch (\Throwable $e) {
            if ($uploadedImage) {
                $this->imageService->delete($uploadedImage, 'trips');
            }

            foreach ($uploadedMedia as $media) {
                $this->imageService->delete($media['original_path'], 'trips/media');
            }

            Log::error('error for store product: ' . $e->getMessage());

            throw $e;
        }
    }

    public function update(int $id, array $data): Trip
    {
        /** @var Trip $trip */
        $trip = $this->repository->findOrFail($id);

        $oldImage = $trip->cover_image;
        $newImage = null;
        $uploadedMedia = [];

        $attachments = $data['attachments'] ?? [];

        if (isset($data['cover_image'])) {
            $newImage = $this->imageService->store($data['cover_image'], 'trips');
            $data['cover_image'] = $newImage;
        }

        try {
            $updated = DB::transaction(function () use ($trip, $data, $attachments, &$uploadedMedia) {
                /** @var Trip $updated */
                $updated = $this->repository->update($trip, $data);

                if (!empty($attachments)) {
                    $files = is_array($attachments) ? $attachments : [$attachments];

                    $uploadedMedia = $this->imageService->storeMany($files, 'trips/media');

                    if (!empty($uploadedMedia)) {
                        $updated->media()->createMany($uploadedMedia);
                    }
                }
                return $updated;
            });
        } catch (\Throwable $e) {
            if ($newImage) {
                $this->imageService->delete($newImage, 'trips');
            }

            Log::error('error for update product: ' . $e->getMessage());

            throw $e;
        }

        if ($newImage && $oldImage) {
            $this->imageService->delete($oldImage, 'trips');
        }

        return $updated->load('media');
    }

    public function delete(int $id): bool
    {
        $trips = $this->repository->findOrFail($id);

        return $this->repository->delete($trips);
    }
}
