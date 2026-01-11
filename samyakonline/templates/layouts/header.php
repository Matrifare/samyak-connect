<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= htmlspecialchars($pageTitle ?? 'Samyak Matrimony') ?> | India's #1 Buddhist Matrimony</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Find your perfect Buddhist life partner on Samyak Matrimony. Verified profiles, secure messaging, and trusted matchmaking for the Buddhist community.">
    <meta name="keywords" content="Buddhist Matrimony, Buddhist Marriage, Buddhist Matchmaking, Buddhist Bride, Buddhist Groom">
    <meta name="author" content="Samyak Matrimony">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle ?? 'Samyak Matrimony') ?>">
    <meta property="og:description" content="India's #1 Buddhist Matrimony - Find your perfect life partner">
    <meta property="og:type" content="website">
    <meta property="og:image" content="images/og-image.jpg">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Modern CSS -->
    <link rel="stylesheet" href="templates/assets/css/modern.css">
    
    <!-- Theme Toggle Script (before body to prevent flash) -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 
                         (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
</head>
<body>
    <!-- Skip to content for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    <!-- Header -->
    <header class="header glass-effect">
        <div class="container">
            <nav class="nav">
                <!-- Logo -->
                <a href="/" class="logo">
                    <img src="logo/logo.png" alt="Samyak Matrimony" class="logo-img" onerror="this.style.display='none'">
                    <span class="logo-text">Samyak<span class="text-gradient">Matrimony</span></span>
                </a>
                
                <!-- Desktop Navigation -->
                <ul class="nav-menu" id="navMenu">
                    <li><a href="/" class="nav-link <?= ($currentPage ?? '') === 'home' ? 'active' : '' ?>">Home</a></li>
                    <li><a href="/search" class="nav-link <?= ($currentPage ?? '') === 'search' ? 'active' : '' ?>">Search</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/matches" class="nav-link <?= ($currentPage ?? '') === 'matches' ? 'active' : '' ?>">Matches</a></li>
                        <li class="nav-dropdown">
                            <a href="#" class="nav-link dropdown-toggle">
                                Messages
                                <?php if (($unreadCount ?? 0) > 0): ?>
                                    <span class="badge badge-primary"><?= $unreadCount ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/messages/inbox">Inbox</a></li>
                                <li><a href="/messages/sent">Sent</a></li>
                                <li><a href="/messages/compose">Compose</a></li>
                            </ul>
                        </li>
                        <li class="nav-dropdown">
                            <a href="#" class="nav-link dropdown-toggle">
                                <img src="<?= htmlspecialchars($_SESSION['user_photo'] ?? '/img/default-avatar.png') ?>" 
                                     alt="Profile" class="nav-avatar">
                                <?= htmlspecialchars($_SESSION['user_name'] ?? 'Account') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                <li><a href="/profile"><i class="fas fa-user"></i> My Profile</a></li>
                                <li><a href="/shortlist"><i class="fas fa-heart"></i> Shortlist</a></li>
                                <li><a href="/interests"><i class="fas fa-paper-plane"></i> Interests</a></li>
                                <li><a href="/settings"><i class="fas fa-cog"></i> Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="/logout" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="/login" class="nav-link">Login</a></li>
                        <li><a href="/register" class="btn btn-primary btn-glow">Register Free</a></li>
                    <?php endif; ?>
                </ul>
                
                <!-- Theme Toggle -->
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
                    <i class="fas fa-sun"></i>
                    <i class="fas fa-moon"></i>
                </button>
                
                <!-- Mobile Menu Toggle -->
                <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </nav>
        </div>
    </header>
    
    <!-- Flash Messages -->
    <?php if ($flash = $_SESSION['flash'] ?? null): ?>
        <?php unset($_SESSION['flash']); ?>
        <div class="toast-container">
            <?php foreach ($flash as $type => $message): ?>
                <div class="toast toast-<?= $type ?>" role="alert">
                    <i class="fas fa-<?= $type === 'success' ? 'check-circle' : ($type === 'error' ? 'exclamation-circle' : 'info-circle') ?>"></i>
                    <span><?= htmlspecialchars($message) ?></span>
                    <button class="toast-close" aria-label="Close">&times;</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main id="main-content">
