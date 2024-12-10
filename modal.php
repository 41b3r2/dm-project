<!-- modal.php -->
<div class="modal" id="authModal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeModal()">&times;</button>

        <!-- Login Form -->
        <div class="form-container" id="loginForm">
            <h2>Login</h2>
            <form action="userlogin.php" method="POST">
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <input type="email" id="loginEmail" name="Email" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" name="Password" required>
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            <div class="switch-form">
                <a href="#" onclick="toggleForm()">Don't have an account? Register here</a>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="form-container" id="registerForm" style="display: none;">
            <h2>Register</h2>
            <form method="POST" action="usersignup.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="form-container1">
                    <div class="form-group1">
                        <label for="Fname">First Name:</label>
                        <input type="text" id="Fname" name="Fname" required>
                    </div>
                    <div class="form-group1">
                        <label for="Mname">Middle Name:</label>
                        <input type="text" id="Mname" name="Mname" required>
                    </div>
                    <div class="form-group1">
                        <label for="Lname">Last Name:</label>
                        <input type="text" id="Lname" name="Lname" required>
                    </div>
                </div>
                <div class="form-container1">
                    <div class="form-group1">
                        <label for="Email">Email:</label>
                        <input type="email" id="Email" name="Email" required>
                    </div>
                    <div class="form-group1">
                        <label for="ContactNo">Phone Number:</label>
                        <input type="number" id="ContactNo" name="ContactNo" required>
                    </div>
                </div>
                <div class="form-container1">
                    <div class="form-group1">
                        <label for="Birthday">Birthday:</label>
                        <input type="date" id="Birthday" name="Birthday" required maxlength="11" oninput="validateContact()" style="padding: 10px;"
                            max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                    </div>                    
                    <div class="form-group1" style="margin-bottom: 20px;">
                        <label for="Gender">Gender:</label>
                        <select id="Gender" name="Gender" required style="width: 100%; padding: 12px; font-size: 14px; border-radius: 5px; background: rgba(255, 255, 255, 0.7);">
                            <option value="" disabled selected>Select your gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group1">
                          <label for="profilepic">Insert Image:</label>
                          <input type="file" id="profilepic" name="profilepic" accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Address">Complete Address:</label>
                    <input type="text" id="Address" name="Address" required>                    
                </div>
                <div class="form-container1">
                    <div class="form-group1">
                        <label for="Password">Password:</label>
                        <input type="password" id="Password" name="Password" required>
                    </div>
                    <div class="form-group1">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Register</button>
            </form>
            <div class="switch-form">
                <a href="#" onclick="toggleForm()">Already have an account? Login here</a>
            </div>
        </div>
    </div>
</div>


<script>
    function validateEmail() {
        var email = document.getElementById('Email').value;
        var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        var errorMessage = document.getElementById('email-error');

        if (!regex.test(email)) {
        errorMessage.style.display = 'inline';
        } else {
        errorMessage.style.display = 'none'; 
        }
    }
    function validateContact() {
        var contact = document.getElementById('ContactNo').value;
        var errorMessage = document.getElementById('contact-error');

        if (contact.length > 11) {
        contact = contact.slice(0, 11);
        document.getElementById('ContactNo').value = contact;
        }

        var regex = /^09\d{9}$/;
        if (!regex.test(contact)) {
        errorMessage.style.display = 'inline';
        } else {
        errorMessage.style.display = 'none';   
        }
    }
    function validateForm() {
        const password = document.getElementById("Password").value;
        const confirm_password = document.getElementById("confirm_password").value;
        if (password !== confirm_password) {
            alert("Passwords do not match!");
            return false;
        }
        return true;
    }
</script>