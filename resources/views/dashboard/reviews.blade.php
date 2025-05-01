<div class="bg-white shadow-md rounded my-6">
    <div class="px-6 py-4 bg-gray-200 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-600">Your Reviews</h2>
    </div>
    <div class="p-6">
        @if($reviews->isEmpty())
        <p class="text-gray-500">You haven't written any reviews yet.</p>
        @else
        <div class="space-y-4">
            @foreach($reviews as $review)
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="font-semibold">{{ $review->service->name ?? 'N/A' }}</h3>
                        <div class="text-yellow-400">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $review->rating)
                                <i class="fas fa-star"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                                @endfor
                        </div>
                    </div>
                    <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                </div>
                <p class="text-gray-600">{{ $review->comment }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="newReviewModal" tabindex="-1" aria-labelledby="newReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newReviewModalLabel">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="service" class="form-label">Service</label>
                        <select class="form-select" id="service" name="service_id" required>
                            <option value="">Select a service</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating">
                            @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                            <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Your Review</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif