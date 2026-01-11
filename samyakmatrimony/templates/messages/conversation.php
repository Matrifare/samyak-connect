<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
.chat-container { height: calc(100vh - 300px); min-height: 400px; display: flex; flex-direction: column; }
.chat-messages { flex: 1; overflow-y: auto; padding: 1rem; }
.message { max-width: 75%; margin-bottom: 1rem; padding: 0.75rem 1rem; border-radius: 1rem; }
.message-sent { background: var(--primary-gradient); color: white; margin-left: auto; border-bottom-right-radius: 0.25rem; }
.message-received { background: var(--gray-100); color: var(--gray-800); margin-right: auto; border-bottom-left-radius: 0.25rem; }
.message-time { font-size: 0.7rem; opacity: 0.7; margin-top: 0.25rem; }
.chat-input { border-top: 1px solid var(--gray-200); padding: 1rem; background: var(--white); }
</style>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <?php include __DIR__ . '/../components/dashboard-sidebar.php'; ?>
            </div>
            
            <!-- Chat -->
            <div class="col-lg-9">
                <div class="card glass-card chat-container">
                    <!-- Chat Header -->
                    <div class="card-header bg-transparent d-flex align-items-center p-3">
                        <a href="/messages" class="btn btn-sm btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
                        <img src="<?= !empty($otherUser['photo']) ? '/uploads/photos/' . $otherUser['photo'] : '/assets/images/default-user.jpg' ?>" 
                             class="rounded-circle me-3" width="45" height="45" style="object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0"><?= htmlspecialchars($otherUser['name'] ?? 'User') ?></h6>
                            <small class="text-muted"><?= htmlspecialchars($otherUser['profile_id'] ?? '') ?></small>
                        </div>
                        <a href="/profile/<?= $otherUser['profile_id'] ?? '' ?>" class="btn btn-sm btn-outline-primary">View Profile</a>
                    </div>
                    
                    <!-- Messages -->
                    <div class="chat-messages" id="chat-messages">
                        <?php if (!empty($messages)): ?>
                            <?php $currentUserId = \App\Core\Session::getUserId(); ?>
                            <?php foreach ($messages as $msg): ?>
                                <div class="message <?= $msg['from_user_id'] == $currentUserId ? 'message-sent' : 'message-received' ?>">
                                    <div class="message-content"><?= htmlspecialchars($msg['content']) ?></div>
                                    <div class="message-time"><?= date('M d, h:i A', strtotime($msg['created_at'])) ?></div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-chat-dots display-4 text-muted"></i>
                                <p class="text-muted mt-2">No messages yet. Start the conversation!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Input -->
                    <div class="chat-input">
                        <form id="message-form" class="d-flex gap-2">
                            <input type="hidden" name="to_user_id" value="<?= $otherUser['id'] ?? 0 ?>">
                            <input type="text" class="form-control" name="message" id="message-input" placeholder="Type your message..." autocomplete="off" required>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const form = document.getElementById('message-form');
    const input = document.getElementById('message-input');
    
    // Scroll to bottom
    chatMessages.scrollTop = chatMessages.scrollHeight;
    
    // Send message
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        
        const toUserId = form.querySelector('[name="to_user_id"]').value;
        const btn = form.querySelector('button');
        btn.disabled = true;
        
        fetch('/messages/send', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
            body: 'to_user_id=' + toUserId + '&message=' + encodeURIComponent(message)
        })
        .then(r => r.json())
        .then(data => {
            btn.disabled = false;
            if (data.success) {
                const msgHtml = `<div class="message message-sent"><div class="message-content">${message}</div><div class="message-time">Just now</div></div>`;
                chatMessages.insertAdjacentHTML('beforeend', msgHtml);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                input.value = '';
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(() => { btn.disabled = false; showToast('Failed to send message', 'error'); });
    });
    
    // Poll for new messages
    <?php if (!empty($messages)): ?>
    let lastMsgId = <?= end($messages)['id'] ?? 0 ?>;
    startMessagePolling(<?= $otherUser['id'] ?? 0 ?>, lastMsgId, chatMessages);
    <?php endif; ?>
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
