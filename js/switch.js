function useDetailPrices() {
setCookie("client_type", 0 , 7);
setCookie("price_type_checked", 0 , 7);
location.reload(); 
    };

function useHurtPrices() {
setCookie("client_type", 1 , 7);
setCookie("price_type_checked", 1 , 7);
location.reload(); 
    };

function setCookie(cname, cvalue, exdays) {
   var d = new Date();
   d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
   var expires = "expires="+d.toUTCString();
   document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}


function changePrices() {
if (document.getElementById('changePricesBtn').checked) 
  {
      useHurtPrices();
  } else {
      useDetailPrices();
  }
 location.reload(); 
};







