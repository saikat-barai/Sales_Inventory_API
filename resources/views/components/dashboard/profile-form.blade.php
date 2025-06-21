<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr />
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control"
                                    type="email" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile" />
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="Entire New Password" class="form-control"
                                    type="password" />
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  bg-gradient-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile();
    async function getProfile() {
        try {
            showLoader();
            let res = await axios.get('/user-profile');
            hideLoader();
            let data = res.data.data;
            // console.log(data.password);
            if (res.status == 200 && res.data.status == 'success') {
                document.getElementById("email").value = data.email;
                document.getElementById("firstName").value = data.first_name;
                document.getElementById("lastName").value = data.last_name;
                document.getElementById("mobile").value = data.mobile;
                // document.getElementById("password").value = data.password;
            } else {
                errorToast(res.data.message);
            }
        } catch (error) {
            hideLoader();
            errorToast("Something went wrong");
        }

    }

    async function onUpdate() {
        let firstName = document.getElementById("firstName").value.trim();
        let lastName = document.getElementById("lastName").value.trim();
        let mobile = document.getElementById("mobile").value.trim();
        let email = document.getElementById("email").value.trim(); // although not used in update
        let password = document.getElementById("password").value;

        if (firstName.length === 0) {
            errorToast('First Name is required');
        } else if (lastName.length === 0) {
            errorToast('Last Name is required');
        } else if (!/^\d{11}$/.test(mobile)) {
            errorToast('Mobile must be a number and exactly 11 digits');
        } else if (password.length === 0) {
            errorToast('Password is required');
        } else {
            try {
                showLoader();
                let res = await axios.post('/user-profile-update', {
                    first_name: firstName,
                    last_name: lastName,
                    mobile: mobile,
                    password: password,

                });
                hideLoader();

                if (res.status === 200 && res.data.status === 'success') {
                    successToast(res.data.message);
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 100);
                } else {
                    errorToast(res.data.message || 'Update failed');
                }
            } catch (error) {
                hideLoader();
                if (error.response.status === 422) {
                    let errors = error.response.data.errors;
                    for (let key in errors) {
                        errorToast(errors[key][0]);
                    }
                } else {
                    errorToast("Something went wrong");
                }
            }
        }
    }
</script>
