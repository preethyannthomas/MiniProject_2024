
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const nameInput = document.getElementById("name");
  const nameError = document.getElementById("name_error_message");
  const mobileInput = document.getElementById("mobile");
  const mobileError = document.getElementById("mobile_error_message");
  const companyNameInput = document.getElementById("company_name");
  const companyNameError = document.getElementById("company_name_error_message");
  const companyEmailInput = document.getElementById("company_email");
  const companyEmailError = document.getElementById("company_email_error_message");
  const passwordInput = document.getElementById("password");
  const passwordError = document.getElementById("password_error_message");
  const confirmPasswordInput = document.getElementById("confirmPassword");
  const confirmPasswordError = document.getElementById("confirmPassword-error");
  const gstinInput = document.getElementById("gstin");
  const gstinError = document.getElementById("gstin_error_message");
  const addressLineInput = document.getElementById("address_line2");
  const addressLineError = document.getElementById("address_line_error_message");
  const areaInput = document.getElementById("area");
  const areaError = document.getElementById("area_error_message");
  const cityInput = document.getElementById("city");
  const cityError = document.getElementById("city_error_message");
  const stateInput = document.getElementById("state");
  const stateError = document.getElementById("state_error_message");
  const zipInput = document.getElementById("zip");
  const zipError = document.getElementById("zip_error_message");
  const termsCheckbox = document.getElementById("terms");
  const termsError = document.getElementById("terms-error");

  form.addEventListener("submit", function (event) {
    if (!isValidForm()) {
      event.preventDefault(); // Prevent form submission
      alert("Please fill in all fields correctly.");
    }
  });

  function isValidForm() {
    return (
      isValidName(nameInput.value) &&
      isValidMobile(mobileInput.value) &&
      isValidCompanyName(companyNameInput.value) &&
      isValidCompanyEmail(companyEmailInput.value) &&
      isValidPassword(passwordInput.value) &&
      isValidConfirmPassword(confirmPasswordInput.value) &&
      isValidGSTIN(gstinInput.value) &&
      isValidAddressLine(addressLineInput.value) &&
      isValidArea(areaInput.value) &&
      isValidCity(cityInput.value) &&
      isValidState(stateInput.value) &&
      isValidZIP(zipInput.value) &&
      termsCheckbox.checked
    );
  }

  nameInput.addEventListener("input", function () {
    validateName();
  });

  mobileInput.addEventListener("input", function () {
    validateMobile();
  });

  companyNameInput.addEventListener("input", function () {
    validateCompanyName();
  });

  companyEmailInput.addEventListener("input", function () {
    validateCompanyEmail();
  });

  passwordInput.addEventListener("input", function () {
    validatePassword();
  });

  confirmPasswordInput.addEventListener("input", function () {
    validateConfirmPassword();
  });

  gstinInput.addEventListener("input", function () {
    validateGSTIN();
  });

  addressLineInput.addEventListener("input", function () {
    validateAddressLine();
  });

  areaInput.addEventListener("input", function () {
    validateArea();
  });

  cityInput.addEventListener("input", function () {
    validateCity();
  });

  stateInput.addEventListener("input", function () {
    validateState();
  });

  zipInput.addEventListener("input", function () {
    validateZIP();
  });

  function isValidName(name) {
    const namePattern = /^[A-Za-z\s]+$/;
    return namePattern.test(name);
  }

  function validateName() {
    if (!isValidName(nameInput.value)) {
      nameError.textContent = "Name should contain only alphabetical characters";
    } else {
      nameError.textContent = "";
    }
  }

  function isValidMobile(mobile) {
    const mobilePattern = /^[6-9]\d{9}$/;
    return mobilePattern.test(mobile);
  }

  function validateMobile() {
    if (!isValidMobile(mobileInput.value)) {
      mobileError.textContent = "Invalid mobile number";
    } else {
      mobileError.textContent = "";
    }
  }

  function isValidCompanyName(companyName) {
    const companyNamePattern = /^[A-Za-z\s]*$/;
    return companyNamePattern.test(companyName);
  }

  function validateCompanyName() {
    if (!isValidCompanyName(companyNameInput.value)) {
      companyNameError.textContent = "Company name should contain only alphabetical characters";
    } else {
      companyNameError.textContent = "";
    }
  }

  function isValidCompanyEmail(companyEmail) {
    const companyEmailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return companyEmailPattern.test(companyEmail);
  }

  function validateCompanyEmail() {
    if (!isValidCompanyEmail(companyEmailInput.value)) {
      companyEmailError.textContent = "Invalid company email format";
    } else {
      companyEmailError.textContent = "";
    }
  }

  function isValidPassword(password) {
    const passPattern = /^[a-zA-Z0-9!@#$%^&*]{6,16}$/;
    return passPattern.test(password);
  }

  function validatePassword() {
    if (!isValidPassword(passwordInput.value)) {
      passwordError.textContent = "Password must contain at least 6 characters with at least one special character";
    } else {
      passwordError.textContent = "";
    }
  }

  function isValidConfirmPassword(confirmPassword) {
    return confirmPassword === passwordInput.value;
  }

  function validateConfirmPassword() {
    if (!isValidConfirmPassword(confirmPasswordInput.value)) {
      confirmPasswordError.textContent = "Passwords do not match";
    } else {
      confirmPasswordError.textContent = "";
    }
  }

  function isValidGSTIN(gstin) {
    const gstinPattern = /^[0-9]{2}[A-Z]{5}[0-9]{4}[1-9A-Z][0-9A-Z]Z[0-9A-Z]$/;
    return gstinPattern.test(gstin);
  }

  function validateGSTIN() {
    if (!isValidGSTIN(gstinInput.value)) {
        gstinError.textContent = "Invalid GSTIN";
    } else {
        gstinError.textContent = ""; // This should clear the error message
    }
  }

  function isValidAddressLine(addressLine) {
    return addressLine.trim() !== "";
  }

  function validateAddressLine() {
    if (!isValidAddressLine(addressLineInput.value)) {
      addressLineError.textContent = "Address cannot be empty";
    } else {
      addressLineError.textContent = "";
    }
  }

  function isValidArea(area) {
    return area.trim() !== "";
  }

  function validateArea() {
    if (!isValidArea(areaInput.value)) {
      areaError.textContent = "Area cannot be empty";
    } else {
      areaError.textContent = "";
    }
  }

  function isValidCity(city) {
    return city.trim() !== "";
  }

  function validateCity() {
    if (!isValidCity(cityInput.value)) {
      cityError.textContent = "City cannot be empty";
    } else {
      cityError.textContent = "";
    }
  }

  function isValidState(state) {
    return state.trim() !== "";
  }

  function validateState() {
    if (!isValidState(stateInput.value)) {
      stateError.textContent = "State cannot be empty";
    } else {
      stateError.textContent = "";
    }
  }

  function isValidZIP(zip) {
    const zipPattern = /^[1-9][0-9]{5}$/;
    return zipPattern.test(zip);
  }

  function validateZIP() {
    if (!isValidZIP(zipInput.value)) {
      zipError.textContent = "Invalid ZIP code";
    } else {
      zipError.textContent = "";
    }
  }
});
