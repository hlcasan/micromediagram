/* Handler for the UI elements in different cases.
    This can be written differently, it’s all front-end stuff
    */


// Function to reset the UI
let resetUI = function () {
    // Do we have a user?
    let u = window.localStorage.getItem("userid") ? true : false;

    //Show when user is logged in
    document.querySelector("#loginContainer").style.display = u ? "none" : "block";
    document.querySelector("#signinContainer").style.display = u ? "none" : "block";
    
    //Show to guests
    document.querySelector("#welcomeContainer").style.display = u ? "block" : "none";
    if (document.querySelector("#commentFContainer")) { //only exists on single.html
        document.querySelector("#commentFContainer").style.display = u ? "block" : "none";
    }

    //Update occurances of the username
    document.querySelector(".welcome").innerHTML = "Welcome " + window.localStorage.getItem("username") + "!";

}

//Initial call
resetUI();



//Log out button
if (document.querySelector("#logout")) {
    document.querySelector("#logout").addEventListener("click", function () {
        window.localStorage.removeItem('userid');
        window.localStorage.removeItem('username');	
    
        resetUI();
    });
}

