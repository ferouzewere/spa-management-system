<div class="card">
    <div class="card-header bg-primary text-white">Your Reviews</div>
    <div class="card-body">
        @if($reviews->isEmpty())
        <p class="text-muted">You haven't submitted any reviews yet.</p>
        @else
        <div class="row">
            @foreach($reviews as $review)
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $review->service->name ?? 'Service' }}</h5>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                        </div>
                        <p class="card-text">{{ $review->comment }}</p>
                        <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#newReviewModal">
            Write a Review
        </button>
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
                            <!-- Add service options dynamically -->
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