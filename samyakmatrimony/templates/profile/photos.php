<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="py-5" style="margin-top: 60px;">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <?php include __DIR__ . '/../components/dashboard-sidebar.php'; ?>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1"><i class="bi bi-images text-primary me-2"></i>Manage Photos</h2>
                        <p class="text-muted mb-0">Upload up to <?= $maxPhotos ?> photos. Drag to reorder.</p>
                    </div>
                    <a href="/profile" class="btn btn-outline-secondary">
                        <i class="bi bi-eye me-2"></i>View Profile
                    </a>
                </div>
                
                <!-- Photo Upload Guidelines -->
                <div class="alert alert-info d-flex align-items-start mb-4">
                    <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                    <div>
                        <h6 class="mb-1">Photo Guidelines</h6>
                        <ul class="mb-0 small">
                            <li>Upload clear, recent photos of yourself</li>
                            <li>First photo will be your profile picture</li>
                            <li>Supported formats: JPG, PNG, GIF, WebP (max 5MB)</li>
                            <li>Drag photos to reorder them</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Photo Gallery Grid -->
                <div class="photo-gallery" id="photoGallery">
                    <?php for ($i = 1; $i <= $maxPhotos; $i++): 
                        $photo = null;
                        foreach ($photos as $p) {
                            if ($p['slot'] === $i) {
                                $photo = $p;
                                break;
                            }
                        }
                    ?>
                    <div class="photo-slot <?= $photo ? 'has-photo' : '' ?>" 
                         data-slot="<?= $i ?>" 
                         draggable="<?= $photo ? 'true' : 'false' ?>">
                        
                        <?php if ($photo): ?>
                            <img src="<?= htmlspecialchars($photo['url']) ?>" 
                                 alt="Photo <?= $i ?>" 
                                 class="photo-preview">
                            <div class="photo-overlay">
                                <div class="photo-actions">
                                    <?php if ($i > 1): ?>
                                    <button type="button" class="btn btn-sm btn-light" 
                                            onclick="setAsPrimary(<?= $i ?>)" title="Set as primary">
                                        <i class="bi bi-star"></i>
                                    </button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-sm btn-light" 
                                            onclick="openCropModal(<?= $i ?>)" title="Crop photo">
                                        <i class="bi bi-crop"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light" 
                                            onclick="replacePhoto(<?= $i ?>)" title="Replace">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="deletePhoto(<?= $i ?>)" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <?php if ($i === 1): ?>
                                <span class="photo-badge primary-badge">
                                    <i class="bi bi-star-fill"></i> Primary
                                </span>
                                <?php endif; ?>
                            </div>
                            <div class="photo-drag-handle">
                                <i class="bi bi-grip-vertical"></i>
                            </div>
                        <?php else: ?>
                            <div class="photo-upload-placeholder" onclick="triggerUpload(<?= $i ?>)">
                                <i class="bi bi-plus-lg"></i>
                                <span>Add Photo</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endfor; ?>
                </div>
                
                <!-- Hidden File Input -->
                <input type="file" id="photoInput" class="d-none" accept="image/jpeg,image/png,image/gif,image/webp">
            </div>
        </div>
    </div>
</section>

<!-- Crop Modal -->
<div class="modal fade" id="cropModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-crop me-2"></i>Crop Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="crop-container">
                    <img id="cropImage" src="" alt="Crop preview">
                </div>
                <div class="crop-controls mt-3">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary" onclick="rotateCrop(-90)">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="rotateCrop(90)">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="flipCropH()">
                            <i class="bi bi-symmetry-horizontal"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="flipCropV()">
                            <i class="bi bi-symmetry-vertical"></i>
                        </button>
                    </div>
                    <div class="btn-group ms-3" role="group">
                        <button type="button" class="btn btn-outline-primary aspect-btn active" data-aspect="1">1:1</button>
                        <button type="button" class="btn btn-outline-primary aspect-btn" data-aspect="0.75">3:4</button>
                        <button type="button" class="btn btn-outline-primary aspect-btn" data-aspect="0">Free</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveCroppedPhoto()">
                    <i class="bi bi-check-lg me-2"></i>Save Photo
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.photo-gallery {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

@media (max-width: 768px) {
    .photo-gallery {
        grid-template-columns: repeat(2, 1fr);
    }
}

.photo-slot {
    position: relative;
    aspect-ratio: 1;
    background: var(--glass-bg);
    border: 2px dashed var(--gray-300);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: var(--transition);
    cursor: pointer;
}

.photo-slot.has-photo {
    border: 2px solid var(--glass-border);
    cursor: grab;
}

.photo-slot.has-photo:active {
    cursor: grabbing;
}

.photo-slot.dragover {
    border-color: var(--primary);
    background: rgba(215, 3, 108, 0.1);
    transform: scale(1.02);
}

.photo-slot.dragging {
    opacity: 0.5;
}

.photo-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.photo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
}

.photo-slot:hover .photo-overlay {
    opacity: 1;
}

.photo-actions {
    display: flex;
    gap: 0.5rem;
}

.photo-actions .btn {
    width: 36px;
    height: 36px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius);
}

.photo-badge {
    position: absolute;
    bottom: 0.75rem;
    left: 50%;
    transform: translateX(-50%);
    background: var(--primary);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-sm);
    font-size: 0.75rem;
    font-weight: 500;
}

.photo-drag-handle {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    background: rgba(255, 255, 255, 0.9);
    color: var(--gray-600);
    width: 28px;
    height: 28px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
    cursor: grab;
}

.photo-slot:hover .photo-drag-handle {
    opacity: 1;
}

.photo-upload-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--gray-500);
    transition: var(--transition);
}

.photo-upload-placeholder i {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.photo-upload-placeholder span {
    font-size: 0.875rem;
    font-weight: 500;
}

.photo-slot:hover .photo-upload-placeholder {
    color: var(--primary);
}

/* Crop Modal */
.crop-container {
    max-height: 60vh;
    background: #1a1a2e;
    border-radius: var(--radius);
    overflow: hidden;
}

.crop-container img {
    max-width: 100%;
    max-height: 60vh;
}

.crop-controls {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.aspect-btn.active {
    background: var(--primary);
    border-color: var(--primary);
    color: white;
}
</style>

<!-- Cropper.js -->
<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.1/dist/cropper.min.js"></script>

<script>
let currentSlot = null;
let cropper = null;
let draggedElement = null;

// Initialize drag and drop
document.querySelectorAll('.photo-slot.has-photo').forEach(slot => {
    slot.addEventListener('dragstart', handleDragStart);
    slot.addEventListener('dragend', handleDragEnd);
});

document.querySelectorAll('.photo-slot').forEach(slot => {
    slot.addEventListener('dragover', handleDragOver);
    slot.addEventListener('dragleave', handleDragLeave);
    slot.addEventListener('drop', handleDrop);
});

function handleDragStart(e) {
    draggedElement = this;
    this.classList.add('dragging');
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', this.dataset.slot);
}

function handleDragEnd(e) {
    this.classList.remove('dragging');
    document.querySelectorAll('.photo-slot').forEach(s => s.classList.remove('dragover'));
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
    if (this !== draggedElement && this.classList.contains('has-photo')) {
        this.classList.add('dragover');
    }
}

function handleDragLeave(e) {
    this.classList.remove('dragover');
}

function handleDrop(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    
    if (this === draggedElement || !this.classList.contains('has-photo')) return;
    
    const fromSlot = parseInt(e.dataTransfer.getData('text/plain'));
    const toSlot = parseInt(this.dataset.slot);
    
    if (fromSlot === toSlot) return;
    
    // Swap photos visually
    const fromImg = draggedElement.querySelector('img').src;
    const toImg = this.querySelector('img').src;
    
    draggedElement.querySelector('img').src = toImg;
    this.querySelector('img').src = fromImg;
    
    // Save new order
    savePhotoOrder();
}

function savePhotoOrder() {
    const slots = [];
    document.querySelectorAll('.photo-slot.has-photo').forEach(slot => {
        slots.push(parseInt(slot.dataset.slot));
    });
    
    fetch('/api/photos/reorder', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order: slots })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) showToast('Photo order updated!');
    });
}

// File upload
function triggerUpload(slot) {
    currentSlot = slot;
    document.getElementById('photoInput').click();
}

function replacePhoto(slot) {
    triggerUpload(slot);
}

document.getElementById('photoInput').addEventListener('change', function() {
    if (this.files[0]) {
        uploadPhoto(this.files[0], currentSlot);
    }
});

async function uploadPhoto(file, slot) {
    const formData = new FormData();
    formData.append('photo', file);
    formData.append('slot', slot);
    
    showToast('Uploading...', 'info');
    
    try {
        const response = await fetch('/api/photos/upload', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            showToast(data.message, 'success');
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        showToast('Upload failed. Please try again.', 'error');
    }
}

// Delete photo
async function deletePhoto(slot) {
    if (!confirm('Are you sure you want to delete this photo?')) return;
    
    try {
        const response = await fetch('/api/photos/delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ slot: slot })
        });
        const data = await response.json();
        
        if (data.success) {
            showToast(data.message, 'success');
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        showToast('Delete failed. Please try again.', 'error');
    }
}

// Set as primary
async function setAsPrimary(slot) {
    try {
        const response = await fetch('/api/photos/set-primary', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ slot: slot })
        });
        const data = await response.json();
        
        if (data.success) {
            showToast(data.message, 'success');
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        showToast('Failed to set primary photo.', 'error');
    }
}

// Crop functionality
function openCropModal(slot) {
    currentSlot = slot;
    const img = document.querySelector(`.photo-slot[data-slot="${slot}"] img`);
    document.getElementById('cropImage').src = img.src;
    
    const modal = new bootstrap.Modal(document.getElementById('cropModal'));
    modal.show();
    
    // Initialize cropper after modal is shown
    document.getElementById('cropModal').addEventListener('shown.bs.modal', initCropper, { once: true });
}

function initCropper() {
    const image = document.getElementById('cropImage');
    
    if (cropper) {
        cropper.destroy();
    }
    
    cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 2,
        dragMode: 'crop',
        autoCropArea: 0.8,
        restore: false,
        guides: true,
        center: true,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false
    });
}

// Aspect ratio buttons
document.querySelectorAll('.aspect-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.aspect-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        const aspect = parseFloat(this.dataset.aspect);
        if (cropper) {
            cropper.setAspectRatio(aspect || NaN);
        }
    });
});

function rotateCrop(deg) {
    if (cropper) cropper.rotate(deg);
}

function flipCropH() {
    if (cropper) {
        const data = cropper.getData();
        cropper.scaleX(data.scaleX === -1 ? 1 : -1);
    }
}

function flipCropV() {
    if (cropper) {
        const data = cropper.getData();
        cropper.scaleY(data.scaleY === -1 ? 1 : -1);
    }
}

async function saveCroppedPhoto() {
    if (!cropper) return;
    
    const canvas = cropper.getCroppedCanvas({
        width: 800,
        height: 800,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    });
    
    const imageData = canvas.toDataURL('image/jpeg', 0.9);
    
    showToast('Saving...', 'info');
    
    try {
        const response = await fetch('/api/photos/upload-cropped', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                image: imageData,
                slot: currentSlot
            })
        });
        const data = await response.json();
        
        if (data.success) {
            showToast(data.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
            location.reload();
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        showToast('Save failed. Please try again.', 'error');
    }
}

// Cleanup cropper on modal close
document.getElementById('cropModal').addEventListener('hidden.bs.modal', function() {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
});

// Toast function
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container') || createToastContainer();
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type === 'info' ? 'info' : 'success'} border-0 show`;
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 5000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
    document.body.appendChild(container);
    return container;
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
