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

    // 8. Dynamic Financial Market Ticker (fluctuating live rates)
    initFinancialTicker();

    // 9. Interactive Weather Widget (with topbar weather syncing)
    initInteractiveWeather();

    // 10. Premium Global Media Lightbox Modals
    initMediaModals();

    // 11. AJAX Comments Loader (Lazy)
    initAJAXComments();

    // 12. Lazy Loading Images (JS based)
    initLazyImages();

    // 13. Live Search Autocomplete
    initLiveSearch();

    // 14. True Dark Mode Toggle
    initDarkMode();
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
    const commentsList = document.getElementById('comments-ajax-container');
    const commentCountEl = document.getElementById('comments-count-header');

    if (!commentForm || !commentsList) return;

    const articleSlug = commentForm.getAttribute('data-slug');
    const parentIdInput = document.getElementById('comment-parent-id');
    const replyIndicator = document.getElementById('reply-indicator');
    const replyToName = document.getElementById('reply-to-name');
    const cancelReplyBtn = document.getElementById('cancel-reply-btn');
    const bodyInput = document.getElementById('comment-body');

    // Handle Reply Button Clicks (using event delegation since comments are loaded via AJAX)
    commentsList.addEventListener('click', (e) => {
        const replyBtn = e.target.closest('.reply-btn');
        if (replyBtn) {
            const commentId = replyBtn.getAttribute('data-id');
            const authorName = replyBtn.getAttribute('data-author');

            if (parentIdInput) parentIdInput.value = commentId;
            if (replyToName) replyToName.textContent = authorName;
            if (replyIndicator) replyIndicator.style.display = 'block';

            // Scroll to form and focus
            if (bodyInput) {
                bodyInput.focus();
                commentForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    // Handle Cancel Reply
    if (cancelReplyBtn) {
        cancelReplyBtn.addEventListener('click', () => {
            if (parentIdInput) parentIdInput.value = '';
            if (replyIndicator) replyIndicator.style.display = 'none';
        });
    }

    commentForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const nameInput = document.getElementById('comment-name');
        const emailInput = document.getElementById('comment-email');

        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const body = bodyInput.value.trim();
        const parent_id = parentIdInput ? parentIdInput.value : null;

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
            body: JSON.stringify({ name, email, body, parent_id })
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

                const item = document.createElement('div');
                item.className = 'comment-item dynamic-comment';
                item.id = 'comment-' + comment.id;
                
                // If it's a reply, find parent and append
                if (comment.parent_id) {
                    item.className = 'comment-item is-reply dynamic-comment';
                    item.innerHTML = `
                        <div class="comment-header">
                            <span class="comment-author">${escapeHTML(comment.name)}</span>
                            <span class="comment-date">${comment.date}</span>
                        </div>
                        <div class="comment-body">
                            ${escapeHTML(comment.body).replace(/\n/g, '<br>')}
                        </div>
                    `;

                    const parentComment = document.getElementById('comment-' + comment.parent_id);
                    if (parentComment) {
                        let repliesContainer = parentComment.querySelector('.comment-replies');
                        if (!repliesContainer) {
                            repliesContainer = document.createElement('div');
                            repliesContainer.className = 'comment-replies';
                            parentComment.appendChild(repliesContainer);
                        }
                        repliesContainer.appendChild(item);
                    } else {
                        // Fallback if parent not found in DOM
                        commentsList.insertBefore(item, commentsList.firstChild);
                    }

                    // Reset reply state
                    if (cancelReplyBtn) cancelReplyBtn.click();
                } else {
                    item.className = 'comment-item is-root dynamic-comment';
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
                }

                // Update dynamic count in header
                const countMatch = commentCountEl ? commentCountEl.textContent.match(/\\d+/) : null;
                const currentCount = countMatch ? parseInt(countMatch[0]) : 0;
                const newTotal = currentCount + 1;

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

/* ==========================================================================
   8. Live Financial Ticker Engine
   ========================================================================== */
function initFinancialTicker() {
    const tickerContainer = document.getElementById('financial-ticker-bar');
    if (!tickerContainer) return;

    let stocks = [
        { name: 'IHSG', value: 7128.45, pct: 0.35, isUp: true, decimals: 2 },
        { name: 'USD/IDR', value: 16210, pct: 0.12, isUp: true, decimals: 0, prefix: 'Rp ' },
        { name: 'EUR/IDR', value: 17540, pct: -0.08, isUp: false, decimals: 0, prefix: 'Rp ' },
        { name: 'BTC/IDR', value: 1120400000, pct: -1.45, isUp: false, decimals: 0, prefix: 'Rp ' },
        { name: 'EMAS', value: 1340000, pct: 0.75, isUp: true, decimals: 0, prefix: 'Rp ', suffix: '/g' }
    ];

    let currentIndex = 0;

    function renderStock(index) {
        const stock = stocks[index];
        const pctSign = stock.isUp ? '+' : '';
        const statusClass = stock.isUp ? 'stock-up' : 'stock-down';
        const arrowIcon = stock.isUp 
            ? `<svg style="width: 10px; height: 10px; display:inline-block;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 3.293a1 1 0 01.707.293l5 5a1 1 0 01-1.414 1.414L13 6.414V17a1 1 0 11-2 0V6.414L7.707 10.707a1 1 0 01-1.414-1.414l5-5A1 1 0 0112 3.293z" clip-rule="evenodd"/></svg>`
            : `<svg style="width: 10px; height: 10px; display:inline-block;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 16.707a1 1 0 01-.707-.293l-5-5a1 1 0 011.414-1.414L11 13.586V3a1 1 0 112 0v10.586l3.293-3.293a1 1 0 111.414 1.414l-5 5a1 1 0 01-.707.293z" clip-rule="evenodd"/></svg>`;

        const valStr = (stock.prefix || '') + stock.value.toLocaleString('id-ID', { minimumFractionDigits: stock.decimals, maximumFractionDigits: stock.decimals }) + (stock.suffix || '');

        // Apply smooth transition properties
        tickerContainer.style.transition = 'all 0.35s cubic-bezier(0.4, 0, 0.2, 1)';
        
        // Fade out & slide up
        tickerContainer.style.opacity = '0';
        tickerContainer.style.transform = 'translateY(-5px)';

        setTimeout(() => {
            tickerContainer.innerHTML = `
                <div class="ticker-stock-item" style="display: flex; align-items: center; gap: 8px;">
                    <span style="color: hsl(220, 10%, 65%); font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Live Pasar:</span>
                    <span style="font-weight: 700; color: #fff; font-size: 0.72rem;">${stock.name}</span>
                    <span style="font-weight: 800; color: #fff; font-size: 0.72rem;">${valStr}</span>
                    <span class="${statusClass}" style="display:inline-flex; align-items:center; gap:2px; font-size: 0.72rem;">
                        ${arrowIcon}
                        <span>${pctSign}${stock.pct.toFixed(2)}%</span>
                    </span>
                </div>
            `;
            // Fade in & slide down to original position
            tickerContainer.style.opacity = '1';
            tickerContainer.style.transform = 'translateY(0)';
        }, 350);
    }

    // Fluctuates stock values slightly to simulate live feed
    function fluctuateStocks() {
        stocks.forEach(stock => {
            const multiplier = (Math.random() - 0.5) * 0.002; 
            stock.value += stock.value * multiplier;
            stock.pct += multiplier * 12;
            stock.isUp = stock.pct > 0;
        });
    }

    renderStock(0);

    // Rotate and fluctuate every 3.5 seconds
    setInterval(() => {
        currentIndex = (currentIndex + 1) % stocks.length;
        fluctuateStocks();
        renderStock(currentIndex);
    }, 3500);
}

/* ==========================================================================
   9. Interactive Weather Widget with City Syncing
   ========================================================================== */
function initInteractiveWeather() {
    const citySelector = document.getElementById('weather-city-selector');
    const cityNameEl = document.getElementById('weather-city-name');
    const tempValEl = document.getElementById('weather-temp-val');
    const condValEl = document.getElementById('weather-condition-val');
    const humidityEl = document.getElementById('weather-humidity-val');
    const windEl = document.getElementById('weather-wind-val');
    const mainIconEl = document.getElementById('weather-main-icon');
    const infoBox = document.querySelector('.weather-info-box');

    // Top bar elements to sync
    const topbarTextEl = document.getElementById('topbar-weather-text');
    const topbarIconEl = document.getElementById('topbar-weather-icon');

    if (!citySelector) return;

    // Indonesian major cities weather mock data
    const weatherData = {
        jakarta: {
            fullName: 'DKI Jakarta',
            temp: '31°C',
            condition: 'Cerah Berawan',
            humidity: '65%',
            wind: '12 km/h',
            iconPath: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />` // Sun icon
        },
        surabaya: {
            fullName: 'Surabaya, Jatim',
            temp: '33°C',
            condition: 'Cerah Menyengat',
            humidity: '58%',
            wind: '16 km/h',
            iconPath: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />` // Sun icon
        },
        bandung: {
            fullName: 'Bandung, Jabar',
            temp: '24°C',
            condition: 'Hujan Ringan',
            humidity: '82%',
            wind: '8 km/h',
            iconPath: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-1 2m4-2l-1 2m4-2l-1 2" />` // Cloud + Rain icon
        },
        medan: {
            fullName: 'Medan, Sumut',
            temp: '29°C',
            condition: 'Berawan Tebal',
            humidity: '74%',
            wind: '10 km/h',
            iconPath: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />` // Cloud icon
        },
        bali: {
            fullName: 'Denpasar, Bali',
            temp: '30°C',
            condition: 'Cerah Berangin',
            humidity: '70%',
            wind: '22 km/h',
            iconPath: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />` // Sun icon
        }
    };

    function updateWeather(cityKey) {
        const data = weatherData[cityKey];
        if (!data) return;

        // Smooth opacity transition
        if (infoBox) {
            infoBox.style.opacity = '0';
            infoBox.style.transform = 'translateY(5px)';
        }

        setTimeout(() => {
            // Update sidebar elements
            if (cityNameEl) cityNameEl.textContent = data.fullName;
            if (tempValEl) tempValEl.textContent = data.temp;
            if (condValEl) condValEl.textContent = data.condition;
            if (humidityEl) humidityEl.textContent = data.humidity;
            if (windEl) windEl.textContent = data.wind;
            if (mainIconEl) mainIconEl.innerHTML = data.iconPath;

            // Sync with Top bar display
            if (topbarTextEl) {
                // Shorten name if it's too long
                const shortCity = cityKey === 'bali' ? 'Bali' : cityKey.charAt(0).toUpperCase() + cityKey.slice(1);
                topbarTextEl.textContent = `${shortCity}, ${data.temp}`;
            }
            if (topbarIconEl) {
                topbarIconEl.innerHTML = data.iconPath;
            }

            // Fade back in
            if (infoBox) {
                infoBox.style.opacity = '1';
                infoBox.style.transform = 'translateY(0)';
            }
        }, 300);
    }

    citySelector.addEventListener('change', (e) => {
        updateWeather(e.target.value);
    });
}

/* ==========================================================================
   10. Premium Global Media Lightbox Modals (YouTube Video & Infographic Zoom)
   ========================================================================== */
function initMediaModals() {
    const modal = document.getElementById('media-modal');
    if (!modal) return;

    const backdrop = modal.querySelector('.media-modal-backdrop');
    const closeBtn = modal.querySelector('.media-modal-close');
    const videoWrapper = document.getElementById('modal-video-wrapper');
    const imageWrapper = document.getElementById('modal-image-wrapper');
    const youtubeIframe = document.getElementById('modal-youtube-iframe');
    const infographicImg = document.getElementById('modal-infographic-img');
    const infographicTitle = document.getElementById('modal-infographic-title');

    function openModal() {
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closeModal() {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = ''; // Restore background scrolling
        
        // Stop YouTube video instantly by resetting src
        if (youtubeIframe) {
            youtubeIframe.src = '';
        }
        
        // Fade contents smoothly before hiding wrappers
        setTimeout(() => {
            if (videoWrapper) videoWrapper.style.display = 'none';
            if (imageWrapper) imageWrapper.style.display = 'none';
            if (infographicImg) infographicImg.src = '';
            if (infographicTitle) infographicTitle.textContent = '';
        }, 400);
    }

    // Bind click events on video title links to open larger light modal
    const openVideoModalLinks = document.querySelectorAll('.open-video-modal');
    openVideoModalLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const card = link.closest('.video-card');
            if (!card) return;
            const iframeLink = card.getAttribute('data-iframe-link');
            if (!iframeLink) return;

            // Activate video wrapper and load embed source with autoplay active
            if (videoWrapper) videoWrapper.style.display = 'block';
            if (imageWrapper) imageWrapper.style.display = 'none';

            if (youtubeIframe) {
                // Safely append autoplay and modestbranding parameters
                const autoplayLink = iframeLink.includes('?') 
                    ? `${iframeLink}&autoplay=1&modestbranding=1` 
                    : `${iframeLink}?autoplay=1&modestbranding=1`;
                youtubeIframe.src = autoplayLink;
            }

            openModal();
        });
    });

    // Bind click events on infographic cards
    const infographicCards = document.querySelectorAll('.infographic-card');
    infographicCards.forEach(card => {
        card.addEventListener('click', (e) => {
            e.preventDefault();
            const imageUrl = card.getAttribute('data-image-url');
            const title = card.getAttribute('data-title');
            if (!imageUrl) return;

            // Activate image wrapper and load visual source
            if (videoWrapper) videoWrapper.style.display = 'none';
            if (imageWrapper) imageWrapper.style.display = 'flex';

            if (infographicImg) {
                infographicImg.src = imageUrl;
            }
            if (infographicTitle) {
                infographicTitle.textContent = title || 'Visualisasi Jurnalisme Data';
            }

            openModal();
        });
    });

    // Add event listeners for modal dismissals
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeModal);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
}


/* ==========================================================================
   11. AJAX Comments Loader
   ========================================================================== */
function initAJAXComments() {
    const container = document.getElementById('comments-ajax-container');
    if (!container) return;
    
    const slug = container.getAttribute('data-slug');
    if (!slug) return;

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                observer.unobserve(entry.target);
                
                fetch(`/article/${slug}/comments-list`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    if (res.ok) return res.text();
                    throw new Error('Gagal memuat komentar');
                })
                .then(html => {
                    // Set smooth fade transition
                    container.style.opacity = '0';
                    setTimeout(() => {
                        container.innerHTML = html;
                        container.style.transition = 'opacity 0.4s ease-in-out';
                        container.style.opacity = '1';
                    }, 200);
                })
                .catch(err => {
                    console.error(err);
                    container.innerHTML = '<div style="padding: 20px; text-align: center; color: red;">Gagal memuat komentar.</div>';
                });
            }
        });
    }, { rootMargin: "0px 0px 200px 0px" }); // Preload a bit before scrolling into view

    observer.observe(container);
}

/* ==========================================================================
   12. JS-Based Image Lazy Loading
   ========================================================================== */
function initLazyImages() {
    const lazyImages = document.querySelectorAll('.lazy-image');
    if (lazyImages.length === 0) return;

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const dataSrc = img.getAttribute('data-src');
                
                if (dataSrc) {
                    // Coba memuat gambar
                    const tempImage = new Image();
                    tempImage.src = dataSrc;
                    
                    tempImage.onload = () => {
                        img.src = dataSrc;
                        img.removeAttribute('data-src');
                        img.classList.add('loaded');
                        
                        // Menghapus efek skeleton dari parent pembungkus jika ada
                        if (img.parentElement && img.parentElement.classList.contains('lazy-image-wrap')) {
                            img.parentElement.classList.add('loaded');
                        }
                    };
                }
                
                observer.unobserve(img);
            }
        });
    }, { rootMargin: "0px 0px 300px 0px" });

        lazyImages.forEach(img => {
        imageObserver.observe(img);
    });
}

// ==========================================================================
// 13. Smart Live Search Autocomplete Functionality
// ==========================================================================
function initLiveSearch() {
    const searchInput = document.getElementById('smart-search-input');
    const autocompleteBox = document.getElementById('search-autocomplete-box');
    
    if (!searchInput || !autocompleteBox) return;

    let debounceTimer;

    const getApiBaseUrl = () => {
        return window.location.origin;
    };

    const escapeHTML = (str) => {
        return str.replace(/[&<>'"]/g, 
            tag => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#39;',
                '"': '&quot;'
            }[tag])
        );
    };

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            autocompleteBox.style.display = 'none';
            autocompleteBox.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`${getApiBaseUrl()}/api/search/autocomplete?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    autocompleteBox.innerHTML = '';
                    
                    if (data.length > 0) {
                        data.forEach(item => {
                            const link = document.createElement('a');
                            link.href = item.url;
                            link.className = 'autocomplete-item';
                            link.innerHTML = `
                                <img src="${item.image}" alt="${escapeHTML(item.title)}" class="autocomplete-image">
                                <div class="autocomplete-details">
                                    <span class="autocomplete-title">${escapeHTML(item.title)}</span>
                                    <span class="autocomplete-category">${escapeHTML(item.category || 'Berita')}</span>
                                </div>
                            `;
                            autocompleteBox.appendChild(link);
                        });
                        
                        // Add a view all results link at the bottom
                        const viewAll = document.createElement('a');
                        viewAll.href = `${getApiBaseUrl()}/search?q=${encodeURIComponent(query)}`;
                        viewAll.className = 'autocomplete-item';
                        viewAll.style.justifyContent = 'center';
                        viewAll.style.color = 'var(--color-primary)';
                        viewAll.style.fontWeight = '800';
                        viewAll.style.fontSize = '0.8rem';
                        viewAll.innerHTML = `Lihat semua hasil untuk "${escapeHTML(query)}" &rarr;`;
                        autocompleteBox.appendChild(viewAll);

                        autocompleteBox.style.display = 'flex';
                    } else {
                        autocompleteBox.innerHTML = `
                            <div style="padding: 15px; text-align: center; color: var(--color-text-muted); font-size: 0.85rem;">
                                Tidak ada hasil ditemukan.
                            </div>
                        `;
                        autocompleteBox.style.display = 'block';
                    }
                })
                .catch(error => console.error('Error fetching autocomplete:', error));
        }, 300); // 300ms debounce
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteBox.contains(e.target)) {
            autocompleteBox.style.display = 'none';
        }
    });

    // Re-open if input is focused and has value
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2 && autocompleteBox.innerHTML !== '') {
            autocompleteBox.style.display = 'flex';
        }
    });
}

// ==========================================================================
// 14. True Dark Mode Toggle Logic
// ==========================================================================
function initDarkMode() {
    const toggleBtn = document.getElementById('dark-mode-toggle');
    if (!toggleBtn) return;

    const sunIcon = toggleBtn.querySelector('.sun-icon');
    const moonIcon = toggleBtn.querySelector('.moon-icon');

    // Check initial state from HTML attribute (which was set by inline script in head)
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    
    // Set initial icons visibility
    if (isDark) {
        if (sunIcon) sunIcon.style.display = 'block';
        if (moonIcon) moonIcon.style.display = 'none';
    } else {
        if (sunIcon) sunIcon.style.display = 'none';
        if (moonIcon) moonIcon.style.display = 'block';
    }

    toggleBtn.addEventListener('click', () => {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);

        if (newTheme === 'dark') {
            if (sunIcon) sunIcon.style.display = 'block';
            if (moonIcon) moonIcon.style.display = 'none';
        } else {
            if (sunIcon) sunIcon.style.display = 'none';
            if (moonIcon) moonIcon.style.display = 'block';
        }
    });
}
