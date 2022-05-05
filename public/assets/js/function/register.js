import Form from "../module/Form.js";
class registerForm extends Form {

    /**
     * Contructor
     */
    constructor() {
        super();
        this.usernameInput = $('#username');
        this.emailInput = $('#email');
        this.passwordInput = $('#password');
        this.comfirmPasswordInput = $('#comfirm-password');
        this.submitButton = $('#register-button');
        this.formTokenInput = $('#form-token');
    }

    /**
     * Trigger button
     */
    trigger() {
        console.log(this.submitButton);
        let self = this;
        this.submitButton.click(function () {
            self.submit();
        });
    }

    /**
     * Get all values in selectors
     */
    getValues() {
        this.username = this.usernameInput.val();
        this.email = this.emailInput.val();
        this.password = this.passwordInput.val();
        this.comfirmPassword = this.comfirmPasswordInput.val();
        this.formToken = this.formTokenInput.val();
    }

    /**
     * Send data request
     */
    send() {
        $.post(HOST_URL + '/register', {
            type: 'register',
            username: this.username,
            email: this.email,
            password: this.password,
            formToken: this.formToken
        }).done(function (data) {
            if (data.error) {
                return alert(data.error);
            } else if (data.success) {
                return success(data.success, '/login');
            }
        });
    }

    /**
     * Valide form brefore sending
     *
     * @return {number}
     */
    valideForm() {
        this.getValues();
        return this.validateEmail(this.email) &
            this.validatePassword(this.password) &
            this.checkPasswords(this.password, this.comfirmPassword);
    }

    /**
     * Submit form
     */
    submit() {
        this.valideForm() ?
            this.send() :
            alert(this.error); // @todo changer les alertes
    }
}
const registerButton = $('#register-button');
registerButton.click(function () {
    let registerObject = new registerForm();
    registerObject.submit();
});