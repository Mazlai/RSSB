const cookieBox = document.querySelector('#cookContainer'), buttons = document.querySelectorAll('.buttonCookie');

const executeCodes = () => {
    //If cookie contains rssb it will be returned and below of this code will not run
    if(document.cookie.includes('memorisedRSSB')) return;

    cookieBox.classList.add('show');
    buttons.forEach((button) => {
        button.addEventListener('click', () => {

            cookieBox.classList.remove('show');

            //If button has acceptBtn id
            if(button.id == "acceptBtn") {
                //Set cookie for 1h
                document.cookie = "cookieFrom= memorisedRSSB; max-age=" + 3600;
            }
        });
    });
};

window.addEventListener("load", executeCodes);