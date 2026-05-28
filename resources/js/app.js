// NusaKini Interactive Frontend Engine
document.addEventListener('DOMContentLoaded', () => {
    // 1. Dynamic Real-time Date-Time Widget
    initLiveDateTime();

    // 2. Reading Progress Bar (Article Detail Page)
    initReadingProgressBar();

    // 3. Bookmark Engine (LocalStorage-backed)
    initBookmarkEngine();

    // 4. Opinion Poll Widget (LocalStorage-backed)
    initOpinionPoll();

    // 5. Article Reactions Widget (LocalStorage-backed)
    initReactions();

    // 6. Interactive Comments Section (Persistent in LocalStorage)
    initCommentsSection();

    // 7. Newsletter and Feedback Interactive Forms
    initFormInteractions();
});

/* ==========================================================================
   1. Live Indonesian Date-Time Display
   ========================================================================== */
function initLiveDateTime() {
    const clockEl = document.getElementById('live-clock');
    if (!clockEl) return;

    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    function updateTime() {
        const now = new Date();
        const dayName = days[now.getDay()];
        const day = now.getDate();
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        clockEl.textContent = `${dayName}, ${day} ${monthName} ${year} - ${hours}:${minutes}:${seconds} WIB`;
    }

    updateTime();
    setInterval(updateTime, 1000);
}

/* ==========================================================================
   2. Reading Progress Bar (Scroll Tracker)
   ========================================================================== */
function initReadingProgressBar() {
    const progressBar = document.getElementById('reading-progress-bar');
    if (!progressBar) return;

    window.addEventListener('scroll', () => {
        const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
        if (totalHeight <= 0) return;
        const progress = (window.scrollY / totalHeight) * 100;
        progressBar.style.width = `${progress}%`;
    });
}

/* ==========================================================================
   3. LocalStorage Bookmarks Engine
   ========================================================================== */
function initBookmarkEngine() {
    const bookmarkBtn = document.getElementById('btn-bookmark-trigger');
    const bookmarkBadge = document.getElementById('bookmark-count-badge');

    // Retrieve saved bookmarks list from LocalStorage
    function getBookmarks() {
        return JSON.parse(localStorage.getItem('nusakini_bookmarks')) || [];
    }

    // Save list back to LocalStorage
    function saveBookmarks(list) {
        localStorage.setItem('nusakini_bookmarks', JSON.stringify(list));
        updateBookmarkBadge();
    }

    // Update the visual bookmark counter badge
    function updateBookmarkBadge() {
        if (!bookmarkBadge) return;
        const count = getBookmarks().length;
        bookmarkBadge.textContent = count;
        bookmarkBadge.style.display = count > 0 ? 'inline-flex' : 'none';
    }

    // Initialize badge count on load
    updateBookmarkBadge();

    // Toggle bookmark for active article detail page
    if (bookmarkBtn) {
        const articleSlug = bookmarkBtn.getAttribute('data-slug');
        const articleTitle = bookmarkBtn.getAttribute('data-title');
        const articleCategory = bookmarkBtn.getAttribute('data-category');
        const articleDate = bookmarkBtn.getAttribute('data-date');
        const articleImage = bookmarkBtn.getAttribute('data-image');
        const articleAuthor = bookmarkBtn.getAttribute('data-author');

        let bookmarks = getBookmarks();
        const isBookmarked = bookmarks.some(b => b.slug === articleSlug);

        if (isBookmarked) {
            bookmarkBtn.classList.add('bookmarked');
            bookmarkBtn.querySelector('.btn-text').textContent = 'Tersimpan';
        }

        bookmarkBtn.addEventListener('click', () => {
            bookmarks = getBookmarks();
            const index = bookmarks.findIndex(b => b.slug === articleSlug);

            if (index > -1) {
                // Remove bookmark
                bookmarks.splice(index, 1);
                bookmarkBtn.classList.remove('bookmarked');
                bookmarkBtn.querySelector('.btn-text').textContent = 'Simpan Artikel';
                showToast('Artikel dihapus dari penanda.');
            } else {
                // Add new bookmark
                bookmarks.push({
                    slug: articleSlug,
                    title: articleTitle,
                    category: articleCategory,
                    date: articleDate,
                    image: articleImage,
                    author: articleAuthor
                });
                bookmarkBtn.classList.add('bookmarked');
                bookmarkBtn.querySelector('.btn-text').textContent = 'Tersimpan';
                showToast('Artikel berhasil disimpan ke penanda!');
            }
            saveBookmarks(bookmarks);
        });
    }

    // If on the Bookmarks Page, dynamically render the bookmarked lists
    const bookmarkPageContainer = document.getElementById('bookmarks-list-container');
    if (bookmarkPageContainer) {
        renderBookmarksPage();
    }

    function renderBookmarksPage() {
        const list = getBookmarks();
        if (list.length === 0) {
            bookmarkPageContainer.innerHTML = `
                <div class="empty-state">
                    <h3>Belum Ada Artikel Tersimpan</h3>
                    <p>Jelajahi portal berita NusaKini dan simpan artikel menarik untuk dibaca nanti.</p>
                    <a href="/" class="btn-cta">Kembali ke Beranda</a>
                </div>
            `;
            return;
        }

        let html = `<div class="news-grid grid-2">`;
        list.forEach(item => {
            html += `
                <article class="news-card" id="bookmark-card-${item.slug}">
                    <div class="card-image-wrap">
                        <span class="category-tag">${item.category}</span>
                        <img src="${item.image}" alt="${item.title}">
                    </div>
                    <div class="card-content">
                        <div class="article-meta">
                            <span class="article-author">${item.author}</span>
                            <span>•</span>
                            <span>${item.date}</span>
                        </div>
                        <h3 class="card-title">
                            <a href="/article/${item.slug}">${item.title}</a>
                        </h3>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:auto; padding-top:15px; border-top:1px solid var(--color-border)">
                            <a href="/article/${item.slug}" class="btn-read-more">Baca Selengkapnya →</a>
                            <button class="delete-bookmark-btn" data-slug="${item.slug}" style="background:none; border:none; color:var(--color-primary); font-size:0.8rem; font-weight:700; cursor:pointer;">
                                Hapus
                            </button>
                        </div>
                    </div>
                </article>
            `;
        });
        html += `</div>`;
        bookmarkPageContainer.innerHTML = html;

        // Hook up delete buttons
        document.querySelectorAll('.delete-bookmark-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const slug = e.target.getAttribute('data-slug');
                let curBookmarks = getBookmarks();
                curBookmarks = curBookmarks.filter(b => b.slug !== slug);
                saveBookmarks(curBookmarks);
                
                // Animate removal
                const card = document.getElementById(`bookmark-card-${slug}`);
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        renderBookmarksPage();
                        showToast('Artikel dihapus.');
                    }, 350);
                }
            });
        });
    }
}

/* ==========================================================================
   4. Interactive Opinion Poll Widget
   ========================================================================== */
function initOpinionPoll() {
    const pollBox = document.getElementById('opinion-poll-widget');
    if (!pollBox) return;

    const optionsView = pollBox.querySelector('.poll-options-view');
    const resultsView = pollBox.querySelector('.poll-results-view');
    const pollButtons = pollBox.querySelectorAll('.poll-option-btn');

    const pollId = pollBox.getAttribute('data-poll-id') || 'poll_1';

    // Check if user has already voted locally
    const hasVoted = localStorage.getItem(`nusakini_${pollId}_voted`);

    if (hasVoted) {
        // Fetch and show dynamic results directly from SQLite
        fetchResultsAndShow();
    } else {
        pollButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const choice = btn.getAttribute('data-option');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch('/poll/vote', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ poll_id: pollId, option: choice })
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.status === 200 || res.status === 201) {
                        localStorage.setItem(`nusakini_${pollId}_voted`, 'true');
                        localStorage.setItem(`nusakini_${pollId}_choice`, choice);
                        showToast(res.body.message || 'Terima kasih atas partisipasi Anda!');
                        renderResults(res.body.results, choice);
                    } else if (res.status === 422) {
                        // Already voted according to server (IP based check)
                        localStorage.setItem(`nusakini_${pollId}_voted`, 'true');
                        showToast(res.body.message, true);
                        fetchResultsAndShow();
                    } else {
                        showToast(res.body.message || 'Terjadi kesalahan.', true);
                    }
                })
                .catch(err => {
                    console.error(err);
                    showToast('Gagal memproses pilihan Anda.', true);
                });
            });
        });
    }

    function fetchResultsAndShow() {
        fetch(`/poll/${pollId}/results`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const choice = localStorage.getItem(`nusakini_${pollId}_choice`);
                    renderResults(data.results, choice);
                }
            })
            .catch(err => {
                console.error('Gagal mengambil hasil polling:', err);
            });
    }

    function renderResults(percentages, userChoice) {
        optionsView.style.display = 'none';
        resultsView.style.display = 'block';

        // Fill bars
        Object.keys(percentages).forEach(key => {
            const pct = percentages[key];
            const fillEl = document.getElementById(`${pollId}-fill-${key}`);
            const textEl = document.getElementById(`${pollId}-pct-${key}`);

            if (textEl) {
                textEl.textContent = `${pct}%`;
            }

            setTimeout(() => {
                if (fillEl) {
                    fillEl.style.width = `${pct}%`;
                    if (key === userChoice) {
                        fillEl.style.backgroundColor = 'var(--color-primary-hover)';
                    }
                }
            }, 100);
        });
    }
}

/* ==========================================================================
   5. Article Reactions Engine
   ========================================================================== */
function initReactions() {
    const reactionBtns = document.querySelectorAll('.reaction-btn');
    if (reactionBtns.length === 0) return;

    const articleSlug = document.querySelector('.article-header')?.getAttribute('data-slug') || 'global';

    reactionBtns.forEach(btn => {
        const type = btn.getAttribute('data-reaction');
        const countSpan = btn.querySelector('.reaction-count');
        const savedKey = `nusakini_reaction_${articleSlug}_${type}`;

        if (localStorage.getItem(savedKey)) {
            btn.classList.add('reacted');
        }

        btn.addEventListener('click', () => {
            const hasReacted = btn.classList.contains('reacted');

            if (hasReacted) {
                showToast('Reaksi Anda sudah tersimpan sebelumnya!');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Send dynamic reaction increment to Laravel DB
            fetch(`/article/${articleSlug}/react`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 || res.status === 201) {
                    btn.classList.add('reacted');
                    localStorage.setItem(savedKey, 'true');
                    countSpan.textContent = res.body.new_count;
                    showToast('Terima kasih! Reaksi Anda berhasil disimpan.');
                } else {
                    showToast(res.body.message || 'Gagal menyimpan reaksi.', true);
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Terjadi kesalahan koneksi.', true);
            });
        });
    });
}

/* ==========================================================================
   6. Persistent Commenting Widget
   ========================================================================== */
function initCommentsSection() {
    const commentForm = document.getElementById('article-comment-form');
    const commentsList = document.getElementById('comments-list-box');
    const commentCountEl = document.getElementById('comments-count-header');

    if (!commentForm || !commentsList) return;

    const articleSlug = commentForm.getAttribute('data-slug');

    commentForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const nameInput = document.getElementById('comment-name');
        const emailInput = document.getElementById('comment-email');
        const bodyInput = document.getElementById('comment-body');

        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const body = bodyInput.value.trim();

        if (!name || !email || !body) {
            showToast('Silakan isi seluruh kolom komentar!', true);
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Post comment to Laravel database endpoint
        fetch(`/article/${articleSlug}/comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name, email, body })
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(res => {
            if (res.status === 200 || res.status === 201) {
                const comment = res.body.data;

                // Remove empty state if present
                const emptyState = commentsList.querySelector('.empty-comments-state');
                if (emptyState) {
                    emptyState.remove();
                }

                // Render the new comment dynamically at the top
                const item = document.createElement('div');
                item.className = 'comment-item dynamic-comment';
                item.innerHTML = `
                    <div class="comment-header">
                        <span class="comment-author">${escapeHTML(comment.name)}</span>
                        <span class="comment-date">${comment.date}</span>
                    </div>
                    <div class="comment-body">
                        ${escapeHTML(comment.body).replace(/\n/g, '<br>')}
                    </div>
                `;
                commentsList.insertBefore(item, commentsList.firstChild);

                // Update dynamic count in header and database attribute
                const baseCommentsCount = parseInt(commentsList.getAttribute('data-base-count')) || 0;
                const newTotal = baseCommentsCount + 1;
                commentsList.setAttribute('data-base-count', newTotal);
                if (commentCountEl) {
                    commentCountEl.textContent = `Komentar (${newTotal})`;
                }

                // Clear input field and notify
                bodyInput.value = '';
                showToast(res.body.message || 'Komentar Anda berhasil dipublikasikan!');
            } else {
                const errorMsg = res.body.message || 'Terjadi kesalahan saat memposting komentar.';
                showToast(errorMsg, true);
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Gagal memposting komentar. Silakan coba kembali.', true);
        });
    });
}

/* ==========================================================================
   7. Form Interactive Modals & Validations (Database Integrated)
   ========================================================================== */
function initFormInteractions() {
    const newsForms = document.querySelectorAll('.newsletter-form-container');
    newsForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const input = form.querySelector('.newsletter-email');
            if (input && input.value.trim() !== '') {
                const userEmail = input.value.trim();
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch('/newsletter/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: userEmail })
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (res.status === 200 || res.status === 201) {
                        input.value = '';
                        showToast(res.body.message);
                    } else {
                        const errorMsg = res.body.errors?.email?.[0] || res.body.message || 'Gagal mendaftar newsletter.';
                        showToast(errorMsg, true);
                    }
                })
                .catch(err => {
                    console.error(err);
                    showToast('Gagal memproses langganan. Silakan coba lagi.', true);
                });
            }
        });
    });

    const contactForm = document.getElementById('portal-contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const name = document.getElementById('contact-name').value.trim();
            const email = document.getElementById('contact-email').value.trim();
            const subjectSelect = document.getElementById('contact-subject');
            const subject = subjectSelect.options[subjectSelect.selectedIndex].text;
            const message = document.getElementById('contact-message').value.trim();

            if (!name || !email || !message) {
                showToast('Mohon lengkapi seluruh kolom formulir!', true);
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            fetch('/contact/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ name, email, subject, message })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                if (res.status === 200 || res.status === 201) {
                    contactForm.reset();
                    
                    const container = contactForm.parentElement;
                    container.innerHTML = `
                        <div style="text-align:center; padding: 40px 20px; background-color: var(--color-primary-soft); border-radius: var(--border-radius-md); border:1px solid var(--color-border)">
                            <svg style="width: 50px; height:50px; color:var(--color-primary); margin-bottom:15px; display:inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 style="margin-bottom:10px; font-family:var(--font-heading)">Pesan Terkirim</h4>
                            <p style="font-size:0.9rem; color:var(--color-text-muted); margin-bottom: 20px;">Halo ${escapeHTML(name)}, terima kasih atas umpan balik Anda. Tim Editorial kami akan segera meninjau pesan Anda.</p>
                            <button id="btn-reset-contact" class="comment-submit-btn">Kirim Pesan Baru</button>
                        </div>
                    `;

                    document.getElementById('btn-reset-contact').addEventListener('click', () => {
                        window.location.reload();
                    });
                } else {
                    const errorMsg = res.body.message || 'Gagal mengirim pesan kontak.';
                    showToast(errorMsg, true);
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Gagal mengirim pesan. Silakan cek koneksi internet Anda.', true);
            });
        });
    }
}

// Global escape HTML helper utility
function escapeHTML(str) {
    return str.replace(/[&<>'"]/g, 
        tag => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            "'": '&#39;',
            '"': '&quot;'
        }[tag] || tag)
    );
}

/* ==========================================================================
   Helper Widget: Toast Notification
   ========================================================================== */
function showToast(message, isError = false) {
    let toast = document.getElementById('portal-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'portal-toast';
        toast.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 12px 25px;
            background-color: var(--color-dark);
            color: #fff;
            border-radius: var(--border-radius-sm);
            font-size: 0.88rem;
            font-weight: 600;
            z-index: 10000;
            box-shadow: var(--shadow-lg);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            gap: 10px;
        `;
        document.body.appendChild(toast);
    }

    toast.style.backgroundColor = isError ? '#cc142d' : 'var(--color-dark)';
    toast.innerHTML = `
        <svg style="width:16px; height:16px; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>${message}</span>
    `;

    setTimeout(() => {
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';
    }, 50);

    setTimeout(() => {
        toast.style.transform = 'translateY(100px)';
        toast.style.opacity = '0';
    }, 4500);
}
