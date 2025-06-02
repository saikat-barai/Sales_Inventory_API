<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br/>
                    <label>4 Digit Code Here</label>
                    <input id="otp" placeholder="Code" class="form-control" type="text"/>

                    <br/>
                    <button onclick="VerifyOtp()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function VerifyOtp() {
    let otp = document.getElementById('otp').value;

    if (otp.length !== 4) {
        errorToast('Invalid OTP');
    } else {
        showLoader();
        try {
            let res = await axios.post('/verify-otp', {
                email: sessionStorage.getItem('email'),
                otp: otp
            });

            hideLoader();

            if (res.status === 200 && res.data.status === 'success') {
                successToast(res.data.message);
                sessionStorage.clear();
                setTimeout(() => {
                    window.location.href = '/resetPassword';
                }, 1000);
            } else {
                errorToast(res.data.message);
            }
        } catch (err) {
            hideLoader();
            if (err.response && err.response.status === 422) {
                let errors = err.response.data.errors;
                for (let [field, messages] of Object.entries(errors)) {
                    errorToast(messages[0]);
                }
            } else if (err.response && err.response.status === 401) {
                errorToast(err.response.data.message);
            } else {
                errorToast('Something went wrong');
            }
        }
    }
}

</script>

