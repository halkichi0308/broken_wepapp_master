'use strict'

let loginForm = {}
let signupForm = {}

let formSwitch = (witchName)=>{
    let _witchName = witchName.replace(/\-/g,'').trim()
    console.log(witchName)
    if(_witchName === 'login'){
        signupForm.setAttribute('hidden', 'hidden')
        loginForm.removeAttribute('hidden') 
    }else{
        loginForm.setAttribute('hidden', 'hidden')
        signupForm.removeAttribute('hidden')  
    }
}
document.addEventListener("DOMContentLoaded", function() {

    loginForm = document.getElementById('loginForm')
    signupForm = document.getElementById('signupForm')

    //using formSwitch argument
    let witchSetFormName = correntForm === 'login' ? 'login' : 'signup'

    formSwitch(witchSetFormName)
});