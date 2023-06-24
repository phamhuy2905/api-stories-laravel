function Validation(selecter, error) {
    const form = document.querySelector(selecter.form)
    const submit = form.querySelector('button')
    submit.addEventListener('click', function(e) {
        selecter.rule.forEach(value => {
            const element = form.querySelector(`${value.option}`)
            const message = value.check(element)
            const message_error = element.parentElement.querySelector(error)
            if(message) {
                e.preventDefault()
                message_error.textContent = message;
            }
            else {
                message_error.textContent = '';
            }
        });
    })
}


function ValidateRequired(option, message) {
    return {
        option,
        check: function(element) {
            return element.value ? undefined : message
        }
    };
}

function ValidatePassword(option, message) {
    return {
        option,
        check: function(element) {
            return element.value.length >=8 ? undefined : message
        }
    };
}

function ValidateConfirm(option, message, confirm) {
    return {
        option,
        check: function(element) {
            const password = element.parentElement.parentElement.querySelector(confirm)
            return element.value == password.value ? undefined : message
        }
    };
}

function ValidateEmail(option, message) {
    const regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    return {
        option,
        check: function(element) {
            const password = element.parentElement.parentElement.querySelector('#password')
            return regex.test(element.value)  ? undefined : message
        }
    };
}


// Validation({
//     form: "#form",
//     rule: [
//         ValidateRequired("#name",'Truong nay bat buoc phai nhap'),
//         ValidatePassword("#password",'Truong nay toi thieu 8 ki tu'),
//         ValidateConfirm("#password_confirm",'Mat khau xac thuc khong trung khop!','#password'),
//         ValidateEmail("#email",'Truong nay khong phai email'),
//     ]
// }, 'span')