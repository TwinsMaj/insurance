const ESTIMATED_VALUE_MIN = 100;
const ESTIMATED_VALUE_MAX = 100000;
const TAX_MIN = 0;
const TAX_MAX = 100;
const INSTALMENT_MIN = 1;
const INSTALMENT_MAX = 12;

function validateForm() {
    const estimatedValue = document.calculatorForm.estimate.value;
    const taxPercentage = document.calculatorForm.tax.value;
    const instalments = document.calculatorForm.instalments.value;

    let estimate_err = true;
    let tax_err = true;
    let instalments_err = true;

    if (estimatedValue === "") {
        displayError('estimate_err', 'please enter a value');
    } else if(isNaN(estimatedValue)) {
        displayError('estimate_err', 'please enter a valid number');
    } else if(estimatedValue < ESTIMATED_VALUE_MIN) {
        displayError('estimate_err', `value cannot be less than ${ESTIMATED_VALUE_MIN}`);
    } else if(estimatedValue > ESTIMATED_VALUE_MAX) {
        displayError('estimate_err', `value cannot be greater than ${ESTIMATED_VALUE_MAX}`);
    } else {
        estimate_err = false;
        displayError('estimate_err', "");
    }

    if (taxPercentage === "" ) {
        displayError('tax_err', 'please enter a value');
    } else if(isNaN(taxPercentage)) {
        displayError('tax_err', 'please enter a valid number');
    } else if(taxPercentage < TAX_MIN) {
        displayError('tax_err', `value cannot be less than ${TAX_MIN}`);
    } else if(taxPercentage > TAX_MAX) {
        displayError('tax_err', `value cannot be greater than ${TAX_MAX}`);
    } else {
        tax_err = false;
        displayError('tax_err', "");
    }

    if (instalments === "" ) {
       displayError('instalments_err', 'please enter a value');
    } else if(isNaN(instalments)) {
        displayError('instalments_err', 'please enter a valid number');
    } else if(instalments < INSTALMENT_MIN) {
        displayError('instalments_err', `value cannot be less than ${INSTALMENT_MIN}`);
    } else if(instalments > INSTALMENT_MAX) {
        displayError('instalments_err', `value cannot be greater than ${INSTALMENT_MAX}`);
    } else {
        instalments_err = false
        displayError('instalments_err', "");
    }

    if((estimate_err || instalments_err || tax_err) === true) {
        return false;
    }
}

function displayError(elemId, message) {
    document.getElementById(elemId).innerHTML = message;
}