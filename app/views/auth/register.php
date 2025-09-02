<?php
$pageTitle = 'Join GoLocal';
ob_start();
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1><i class="fas fa-user-plus"></i> Join GoLocal</h1>
            <p>Start your authentic Bangladesh experience</p>
        </div>
        
        <form method="POST" class="auth-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="full_name">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input type="text" id="full_name" name="full_name" required 
                           placeholder="Your full name">
                </div>
                
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-at"></i>
                        Username
                    </label>
                    <input type="text" id="username" name="username" required 
                           placeholder="Choose a username">
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i>
                    Email Address
                </label>
                <input type="email" id="email" name="email" required 
                       placeholder="your.email@example.com">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="country">
                        <i class="fas fa-globe"></i>
                        Country
                    </label>
                    <input type="text" id="country" name="country" 
                           placeholder="Your home country">
                </div>
                
                <div class="form-group">
                    <label for="phone">
                        <i class="fas fa-phone"></i>
                        Phone
                    </label>
                    <input type="text" id="phone" name="phone" 
                           placeholder="+1234567890">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i>
                        Password
                    </label>
                    <input type="password" id="password" name="password" required 
                           placeholder="At least 6 characters">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">
                        <i class="fas fa-lock"></i>
                        Confirm Password
                    </label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           placeholder="Repeat password">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Create Account
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Already have an account? 
               <a href="<?= BASE_URL ?>/auth/login">Sign In</a>
            </p>
        </div>
    </div>
    
    <!-- Background Feature -->
    <div class="auth-bg">
        <div class="auth-bg-overlay">
            <h2>Welcome to Bangladesh</h2>
            <p>Join thousands of travelers discovering the beauty and culture of Bangladesh through local eyes</p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/layouts/main.php';
?>