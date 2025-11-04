@push('styles')
<style>
.article-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    min-height: 60vh;
    display: flex;
    align-items: center;
    position: relative;
    padding: 4rem 0;
}

.article-category {
    display: inline-block;
    background: #0d6efd;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 1.5rem;
}

.article-title {
    color: white;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 2rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.article-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.95rem;
}

.author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}


/* Basic Article Content Styles */
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    color: #2c3e50;
    font-weight: 700;
    margin: 2rem 0 1rem 0;
}

.article-content h1 { font-size: 2.5rem; }
.article-content h2 { font-size: 2rem; }
.article-content h3 { font-size: 1.75rem; }
.article-content h4 { font-size: 1.5rem; }
.article-content h5 { font-size: 1.25rem; }
.article-content h6 { font-size: 1.1rem; }

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content img {
    border-radius: 0.5rem;
    margin: 2rem 0;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    max-width: 100%;
    height: auto;
}

.article-content blockquote {
    background: #f8f9fa;
    border-left: 4px solid #0d6efd;
    padding: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    border-radius: 0 0.5rem 0.5rem 0;
}

.article-content ul,
.article-content ol {
    margin: 1.5rem 0;
    padding-left: 1.5rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content table {
    margin: 2rem 0;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    width: 100%;
}

.article-content .alert {
    border-radius: 0.5rem;
    border: none;
    padding: 1.5rem;
    margin: 2rem 0;
}

/* Author Card */
.author-card {
    display: flex;
    gap: 1.5rem;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    margin: 3rem 0;
}

.author-avatar-lg {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.author-avatar-lg img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.social-links {
    margin-top: 1rem;
}

.social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #0d6efd;
    color: white;
    text-decoration: none;
    margin-right: 0.5rem;
    transition: background-color 0.2s ease;
}

.social-links a:hover {
    background: #0b5ed7;
    color: white;
}

/* Comments Section */
.comments-section {
    margin: 3rem 0;
}

.comment {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.comment-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.comment-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.comment-content {
    flex: 1;
}

.comment-meta {
    margin-bottom: 0.5rem;
}

.comment-meta h5 {
    margin: 0;
    font-size: 1rem;
    color: #333;
}

.comment-date {
    font-size: 0.875rem;
    color: #6c757d;
}

.comment-reply {
    color: #0d6efd;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.comment-reply:hover {
    text-decoration: underline;
}

.comment-form {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 0.5rem;
}

/* Sidebar Styles */
.sidebar-card {
    background: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
}

.sidebar-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.job-card-sidebar {
    padding: 1rem 0;
    border-bottom: 1px solid #e9ecef;
}

.job-card-sidebar:last-child {
    border-bottom: none;
}

.job-card-sidebar h5 {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.25rem;
}

.job-type {
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.job-type.fulltime {
    background: #d4edda;
    color: #155724;
}

.job-type.freelance {
    background: #fff3cd;
    color: #856404;
}

.job-type.parttime {
    background: #d1ecf1;
    color: #0c5460;
}

/* Related Articles */
.article-card {
    background: white;
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
    transition: transform 0.2s ease;
}

.article-card:hover {
    transform: translateY(-3px);
}

.article-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.article-body {
    padding: 1.5rem;
}

.resource-category {
    display: inline-block;
    background: #e9ecef;
    color: #6c757d;
    padding: 0.25rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}

.article-body h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.article-body p {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .article-hero {
        min-height: 50vh;
        padding: 3rem 0;
    }
    
    .article-title {
        font-size: 2rem;
    }
    
    .article-meta {
        flex-direction: column;
        gap: 1rem;
    }
    
    .author-card {
        flex-direction: column;
        text-align: center;
    }
    
    .comment {
        flex-direction: column;
    }
    
    .article-content h1 { font-size: 2rem; }
    .article-content h2 { font-size: 1.75rem; }
    .article-content h3 { font-size: 1.5rem; }
    .article-content h4 { font-size: 1.25rem; }
    .article-content h5 { font-size: 1.1rem; }
    .article-content h6 { font-size: 1rem; }
}
</style>
@endpush
<div>
    <section class="article-hero" @if($post->featured_image) style="background:url({{ Storage::url($post->featured_image) }});background-size: cover;
    background-position: center;
    background-attachment: fixed;" @endif>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="article-category">{{ $post->category ?? 'Uncategorized' }}</span>
                    <h1 class="article-title">{{ $post->title }}</h1>

                    <div class="article-meta d-flex align-items-center justify-content-center">
                        <div class="article-author mb-0">
                            <div class="author-avatar">
                                <img src="{{ $post->user->image }}" alt="Author">
                            </div>
                            <span>By {{ $post->user->name }}</span>
                        </div>
                        <div class="article-date d-flex align-items-center text-white">
                            <i class="far fa-clock me-2 "></i> {{ $post->published_at->format('F d, Y') }} • {{ $post->reading_time }} min read
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- Article Content -->
            <div class="col-lg-8">
                <div class="article-content">
                    {!! $post->content !!}
                </div>

                <!-- Author Bio -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="social-links">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fas fa-globe"></i></a>
                    </div>
                    @if(!empty($post->tags))
                        <div class="article-tags">
                            <span class="text-muted">Tags:</span>
                            @foreach($post->tags as $tag)
                                <button class="btn btn-sm btn-outline-primary me-1">{{ trim(ucfirst($tag)) }}</button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Comments Section -->
                <div class="comments-section">
                    <h3 class="sidebar-title">Comments (12)</h3>

                    <div class="comment">
                        <div class="comment-avatar">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User">
                        </div>
                        <div class="comment-content">
                            <div class="comment-meta">
                                <h5>Michael Thompson</h5>
                                <span class="comment-date">October 16, 2023</span>
                            </div>
                            <p>Great article! I never realized how much my generic objective statement was hurting my chances. I rewrote my resume with a professional summary and already got two interview requests this week.</p>
                            <a href="#" class="comment-reply">Reply</a>

                            <!-- Reply Comment -->
                            <div class="comment mt-4">
                                <div class="comment-avatar">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User">
                                </div>
                                <div class="comment-content">
                                    <div class="comment-meta">
                                        <h5>Sarah Johnson</h5>
                                        <span class="comment-date">October 17, 2023</span>
                                    </div>
                                    <p>Same here Michael! I followed the advice about using action verbs and quantifying achievements. The difference has been amazing - my response rate has doubled.</p>
                                    <a href="#" class="comment-reply">Reply</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="comment">
                        <div class="comment-avatar">
                            <img src="https://randomuser.me/api/portraits/women/26.jpg" alt="User">
                        </div>
                        <div class="comment-content">
                            <div class="comment-meta">
                                <h5>Emily Rodriguez</h5>
                                <span class="comment-date">October 15, 2023</span>
                            </div>
                            <p>The section about ATS keywords was an eye-opener. I've been applying for months with no responses. After optimizing my resume with relevant keywords, I got my first callback yesterday. Thank you!</p>
                            <a href="#" class="comment-reply">Reply</a>
                        </div>
                    </div>

                    <div class="comment">
                        <div class="comment-avatar">
                            <img src="https://randomuser.me/api/portraits/men/65.jpg" alt="User">
                        </div>
                        <div class="comment-content">
                            <div class="comment-meta">
                                <h5>David Chen</h5>
                                <span class="comment-date">October 15, 2023</span>
                            </div>
                            <p>Excellent advice, especially about quantifying achievements. I used to list responsibilities, but after adding metrics to my resume, recruiters are much more interested in my background.</p>
                            <a href="#" class="comment-reply">Reply</a>
                        </div>
                    </div>

                    <!-- Comment Form -->
                    <div class="mt-5">
                        <h4>Leave a Comment</h4>
                        <form class="comment-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Your Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Your Email">
                                </div>
                            </div>
                            <textarea class="form-control" rows="5" placeholder="Your Comment"></textarea>
                            <button type="submit" class="btn btn-primary mt-3">Post Comment</button>
                        </form>
                    </div>
                </div>

                <!-- Related Articles -->
                <div class="related-articles">
                    <h3 class="sidebar-title">Related Articles</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="article-card">
                                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" class="img-fluid article-img" alt="Interview Prep">
                                <div class="article-body">
                                    <span class="resource-category">Interview Prep</span>
                                    <h5>Ace Your Next Virtual Interview: The Complete Guide</h5>
                                    <p class="text-muted">Master the art of remote interviewing with these essential tips and techniques.</p>
                                    <a href="#" class="btn btn-link p-0">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="article-card">
                                <img src="https://images.unsplash.com/photo-1581094794329-16d62e7c3aec?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" class="img-fluid article-img" alt="Salary Negotiation">
                                <div class="article-body">
                                    <span class="resource-category">Salary Negotiation</span>
                                    <h5>Negotiate Your Salary Like a Pro: The Complete Playbook</h5>
                                    <p class="text-muted">Get the compensation you deserve with these proven negotiation strategies.</p>
                                    <a href="#" class="btn btn-link p-0">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Featured Jobs -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Featured Jobs</h3>

                    <div class="job-card-sidebar">
                        <h5>Frontend Developer</h5>
                        <p class="text-muted mb-2">TechVision Inc.</p>
                        <div class="d-flex justify-content-between">
                            <span class="job-type fulltime">Full-time</span>
                            <span class="text-primary">$85k - $110k</span>
                        </div>
                    </div>

                    <div class="job-card-sidebar">
                        <h5>UX/UI Designer</h5>
                        <p class="text-muted mb-2">Creative Solutions</p>
                        <div class="d-flex justify-content-between">
                            <span class="job-type freelance">Freelance</span>
                            <span class="text-primary">$60 - $85/hr</span>
                        </div>
                    </div>

                    <div class="job-card-sidebar">
                        <h5>Marketing Manager</h5>
                        <p class="text-muted mb-2">Growth Hackers</p>
                        <div class="d-flex justify-content-between">
                            <span class="job-type fulltime">Full-time</span>
                            <span class="text-primary">$75k - $95k</span>
                        </div>
                    </div>

                    <div class="job-card-sidebar">
                        <h5>Content Writer</h5>
                        <p class="text-muted mb-2">Global Media</p>
                        <div class="d-flex justify-content-between">
                            <span class="job-type parttime">Part-time</span>
                            <span class="text-primary">$40 - $60/hr</span>
                        </div>
                    </div>

                    <div class="job-card-sidebar">
                        <h5>Data Analyst</h5>
                        <p class="text-muted mb-2">DataSystems Corp</p>
                        <div class="d-flex justify-content-between">
                            <span class="job-type fulltime">Full-time</span>
                            <span class="text-primary">$70k - $90k</span>
                        </div>
                    </div>

                    <a href="#" class="btn btn-outline-primary w-100 mt-3">View All Jobs</a>
                </div>

                <!-- Newsletter -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Career Newsletter</h3>
                    <p>Get the latest job search tips, industry insights, and exclusive opportunities delivered to your inbox.</p>

                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Your email address">
                    </div>
                    <button class="btn btn-primary w-100">Subscribe</button>
                </div>

                <!-- Resource Categories -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Resource Categories</h3>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Career Advice
                            <span class="badge bg-primary rounded-pill">24</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Resume Tips
                            <span class="badge bg-primary rounded-pill">18</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Interview Prep
                            <span class="badge bg-primary rounded-pill">15</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Freelancing
                            <span class="badge bg-primary rounded-pill">22</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Salary Negotiation
                            <span class="badge bg-primary rounded-pill">9</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Professional Branding
                            <span class="badge bg-primary rounded-pill">12</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>