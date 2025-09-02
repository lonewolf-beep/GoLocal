<?php
$pageTitle = 'Login to GoLocal';
ob_start();
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1><i class="fas fa-sign-in-alt"></i> Welcome Back</h1>
            <p>Sign in to continue your Bangladesh adventure</p>
        </div>
        
        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i>
                    Email Address
                </label>
                <input type="email" id="email" name="email" required 
                       placeholder="Enter your email">
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i>
                    Password
                </label>
                <input type="password" id="password" name="password" required 
                       placeholder="Enter your password">
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Don't have an account? 
               <a href="<?= BASE_URL ?>/auth/register">Join GoLocal</a>
            </p>
        </div>
    </div>
    
    <!-- Background Feature -->
    <div class="auth-bg">
        <div class="auth-bg-overlay">
            <h2>Explore Bangladesh</h2>
            <p>Connect with locals, discover hidden gems, and create unforgettable memories</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/layouts/main.php';
?>