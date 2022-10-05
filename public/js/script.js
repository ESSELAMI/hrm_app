"use strict";
$(document).ready(function() {
    var $window = $(window);
    //add id to main menu for mobile menu start
    var getBody = $("body");
    var bodyClass = getBody[0].className;
    $(".main-menu").attr('id', bodyClass);
    //add id to main menu for mobile menu end

    // card js start
    $(".card-header-right .close-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function() {
            $this.parents('.card').remove();
        }, 800);
    });

    $(".card-header-right .minimize-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("icon-minus").fadeIn('slow');
        $(this).toggleClass("icon-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("icon-maximize");
        $(this).toggleClass("icon-minimize");
    });

    $("#more-details").on('click', function() {
        $(".more-details").slideToggle(500);
    });
    $(".mobile-options").on('click', function() {
        $(".navbar-container .nav-right").slideToggle('slow');
    });
    // card js end
    $.mCustomScrollbar.defaults.axis = "yx";
    $("#styleSelector .style-cont").slimScroll({
        setTop: "10px",
        height:"calc(100vh - 440px)",
    });
    $(".main-menu").mCustomScrollbar({
        setTop: "10px",
        setHeight: "calc(100% - 80px)",
    });
    /*chatbar js start*/

    /*chat box scroll*/
    var a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5,
        color: '#1b8bf9'
    });

    // search
    $("#search-friends").on("keyup", function() {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function() {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    // open chat box
    $('.displayChatbox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat').toggle('slide', options, 500);
    });


    //open friend chat
    $('.userlist-box').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
    });
    //back to main chatbar
    $('.back_chatBox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    // /*chatbar js end*/
    $(".search-btn").on('click', function() {
        $(".main-search").addClass('open');
        $('.main-search .form-control').animate({
            'width': '200px',
        });
    });
    $(".search-close").on('click', function() {
        $('.main-search .form-control').animate({
            'width': '0',
        });
        setTimeout(function() {
            $(".main-search").removeClass('open');
        }, 300);
    });
    $('#mobile-collapse i').addClass('icon-toggle-right');
    $('#mobile-collapse').on('click', function() {
        $('#mobile-collapse i').toggleClass('icon-toggle-right');
        $('#mobile-collapse i').toggleClass('icon-toggle-left');
    });
});
$(document).ready(function() {
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $('.theme-loader').fadeOut('slow', function() {
        $(this).remove();
    });

    // init Sounds

});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;
    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    $('.full-screen').toggleClass('icon-maximize');
    $('.full-screen').toggleClass('icon-minimize');
}

function notify(title, message, color, position,transition){
    iziToast.show({
        title: title,
        message: message,
        position: position,
        color: color,
        transitionIn: transition,
        timeout : 3000,
        zindex: 9999999,
        'z-index': 9999999,
        targetFirst : true,
    });



};
function overlap (timeSegments) {
    window['moment-range'].extendMoment(moment);
let ret = false;
let i = 0;
while( !ret && i<timeSegments.length-1 ){
let seg1 = timeSegments[i];
let seg2 = timeSegments[i+1];
let range1 = moment.range( moment(seg1[0], 'HH:mm'),  moment(seg1[1], 'HH:mm'));
let range2 = moment.range( moment(seg2[0], 'HH:mm'),  moment(seg2[1], 'HH:mm'));
if( range1.overlaps(range2) ){
ret = true;
}
i++;

return ret;
}
};
function getDates(startDate, stopDate) {
    var dateArray = [];
    var currentDate = moment(startDate);
    var stopDate = moment(stopDate);
    while (currentDate <= stopDate) {
        dateArray.push( moment(currentDate).format('YYYY-MM-DD') )
        currentDate = moment(currentDate).add(1, 'days');
    }
    return dateArray;
}
// to convert a string to Date format :)
function formatDateTime(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear(),
        hours = ("0" + d.getHours()).slice(-2),
        minutes = ("0" + d.getMinutes()).slice(-2);

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-')+' '+[hours,minutes].join(':');

}

  function reFormatDateTime(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear(),
        hours = ("0" + d.getHours()).slice(-2),
        minutes = ("0" + d.getMinutes()).slice(-2);
    
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [day, month, year].join('/')+' - '+[hours,minutes].join(':');
     
}
  function reFormatTime(time) {
    var d = time
    if(d){
        d=d.slice(0,5);
    }
    
    // if (month.length < 2) month = '0' + month;
    // if (day.length < 2) day = '0' + day;
    return d;
     
}
  function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

  function reFormatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month, year].join('/');
    }

    function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = " ") {
        try {
          decimalCount = Math.abs(decimalCount);
          decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

          const negativeSign = amount < 0 ? "-" : "";

          let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
          let j = (i.length > 3) ? i.length % 3 : 0;

          return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
          console.log(e)
        }
      };

      function removeString(string, from) {
        var newString = from.replace(string,'');
        return newString
    }

    function groupBy(list, keyGetter) {
        const map = new Map();
        list.forEach((item) => {
            const key = keyGetter(item);
            const collection = map.get(key);
            if (!collection) {
                map.set(key, [item]);
            } else {
                collection.push(item);
            }
        });
        return map;
    }

   /*
'*********** 
' Devise=0   aucune 
'       =1   Euro  
'       =2   Dollar $ 
' Langue=0   Français 
'       =1   Belgique 
'       =2   Suisse 
'*********** 
' Conversion limitée à 999 999 999 999 999 ou 9 999 999 999 999,99 
' si le nombre contient plus de 2 décimales, il est arrondit à 2 décimales 
*/
function ConvNumberLetter_fr(Nombre, bCheckFloat) {	
	var strNombre = new String(Nombre) ;
	var TabNombre = new Array() ;
	var strLetter = new String() ;
	
	if(isNaN(parseFloat(Nombre))) return "";
	
	if(bCheckFloat) {
		TabNombre = strNombre.split(".") ;
		if(TabNombre.length > 2 || TabNombre.length <= 0) return "" ;
		for(var i = 0; i < TabNombre.length; i++) {
			if(i == 0) 
				strLetter = strLetter + ConvNumberLetter(parseFloat(TabNombre[i]), 1, 0) ;
			else
				strLetter = strLetter + ConvNumberLetter(parseFloat(TabNombre[i]), 0, 0) ;
		}
		return strLetter ;
	}
	else {
		strLetter = ConvNumberLetter(Nombre, 1, 0) ;
		return strLetter ;
	}
}

function ConvNumberLetter(Nombre, Devise, Langue) {
    var dblEnt, byDec ; 
    var bNegatif; 
    var strDev = new String();
	var strCentimes = new String();
    
    if( Nombre < 0 ) {
        bNegatif = true;
        Nombre = Math.abs(Nombre);
    }
    dblEnt = parseInt(Nombre) ;
    byDec = parseInt((Nombre - dblEnt) * 100) ;
    if( byDec == 0 ) {
        if (dblEnt > 999999999999999) {
            return "#TropGrand" ;            
        }
	}
    else {
        if (dblEnt > 9999999999999.99) {
            return "#TropGrand" ;            
        }    
	}
	switch(Devise) {
        case 0 :
            if (byDec > 0) strDev = " virgule" ;
			break;
        case 1 :
            strDev = " Euro" ;
            if (byDec > 0) strCentimes = strCentimes + " Cents" ;
			break;
        case 2 :
            strDev = " Dollar" ;
            if (byDec > 0) strCentimes = strCentimes + " Cent" ;
			break;
	}
    if (dblEnt > 1 && Devise != 0) strDev = strDev + "s" ;
    
	var NumberLetter = ConvNumEnt(parseFloat(dblEnt), Langue) + strDev + " " + ConvNumDizaine(byDec, Langue) + strCentimes ;
	return NumberLetter;
}

function ConvNumEnt(Nombre, Langue) {
    var byNum, iTmp, dblReste ;
    var StrTmp = new String();
    var NumEnt ;
    iTmp = Nombre - (parseInt(Nombre / 1000) * 1000) ;
    NumEnt = ConvNumCent(parseInt(iTmp), Langue) ;
    dblReste = parseInt(Nombre / 1000) ;
    iTmp = dblReste - (parseInt(dblReste / 1000) * 1000) ;
    StrTmp = ConvNumCent(parseInt(iTmp), Langue) ;
    switch(iTmp) {
        case 0 :
			break;
        case 1 :
            StrTmp = "mille " ; 
			break;
        default : 
            StrTmp = StrTmp + " mille " ;
    }
    NumEnt = StrTmp + NumEnt ;
    dblReste = parseInt(dblReste / 1000) ;
    iTmp = dblReste - (parseInt(dblReste / 1000) * 1000) ;
    StrTmp = ConvNumCent(parseInt(iTmp), Langue) ;
    switch(iTmp) {
        case 0 :
			break;
        case 1 :
            StrTmp = StrTmp + " million " ;
			break;
        default : 
            StrTmp = StrTmp + " millions " ;
    }
    NumEnt = StrTmp + NumEnt ;
    dblReste = parseInt(dblReste / 1000) ;
    iTmp = dblReste - (parseInt(dblReste / 1000) * 1000) ;
    StrTmp = ConvNumCent(parseInt(iTmp), Langue) ;
	switch(iTmp) {
        case 0 :
			break;
        case 1 :
            StrTmp = StrTmp + " milliard " ;
			break;
        default : 
            StrTmp = StrTmp + " milliards " ;
    }
    NumEnt = StrTmp + NumEnt ;
    dblReste = parseInt(dblReste / 1000) ;
    iTmp = dblReste - (parseInt(dblReste / 1000) * 1000) ;
    StrTmp = ConvNumCent(parseInt(iTmp), Langue) ;
   	switch(iTmp) {
        case 0 :
			break;
        case 1 :
            StrTmp = StrTmp + " billion " ;
			break;
        default : 
            StrTmp = StrTmp + " billions " ;
    }
    NumEnt = StrTmp + NumEnt ;
 	return NumEnt;    
}

function ConvNumDizaine(Nombre, Langue) {
    var TabUnit, TabDiz ;
    var byUnit, byDiz ;
    var strLiaison = new String() ;
    
    TabUnit = Array("", "un", "deux", "trois", "quatre", "cinq", "six", "sept",
        "huit", "neuf", "dix", "onze", "douze", "treize", "quatorze", "quinze",
        "seize", "dix-sept", "dix-huit", "dix-neuf") ;
    TabDiz = Array("", "", "vingt", "trente", "quarante", "cinquante",
        "soixante", "soixante", "quatre-vingt", "quatre-vingt") ;
    if (Langue == 1) {
        TabDiz[7] = "septante" ;
        TabDiz[9] = "nonante" ;
	}
    else if (Langue == 2) {
        TabDiz[7] = "septante" ;
        TabDiz[8] = "huitante" ;
        TabDiz[9] = "nonante" ;
    }
    byDiz = parseInt(Nombre / 10) ;
    byUnit = Nombre - (byDiz * 10) ;
    strLiaison = "-" ;
    if (byUnit == 1) strLiaison = " et " ;
    switch(byDiz) {
        case 0 :
            strLiaison = "" ;
			break;
        case 1 :
            byUnit = byUnit + 10 ;
            strLiaison = "" ;
			break;
        case 7 :
            if (Langue == 0) byUnit = byUnit + 10 ;
			break;
        case 8 :
            if (Langue != 2) strLiaison = "-" ;
			break;
        case 9 :
            if (Langue == 0) {
                byUnit = byUnit + 10 ;
                strLiaison = "-" ;
            }
			break;
    }
    var NumDizaine = TabDiz[byDiz] ;
    if (byDiz == 8 && Langue != 2 && byUnit == 0) NumDizaine = NumDizaine + "s" ;
    if (TabUnit[byUnit] != "") {
        NumDizaine = NumDizaine + strLiaison + TabUnit[byUnit] ;
	}
    else {
        NumDizaine = NumDizaine ;
    } 
	return NumDizaine;
}

function ConvNumCent(Nombre, Langue) {
    var TabUnit ;
    var byCent, byReste ;
    var strReste = new String() ;
    var NumCent;
    TabUnit = Array("", "un", "deux", "trois", "quatre", "cinq", "six", "sept","huit", "neuf", "dix") ;
    
    byCent = parseInt(Nombre / 100) ;
    byReste = Nombre - (byCent * 100) ; 
    strReste = ConvNumDizaine(byReste, Langue) 
    switch(byCent) {
        case 0 :
            NumCent = strReste ;
			break;
        case 1 :
            if (byReste == 0)
                NumCent = "cent" ;
            else 
                NumCent = "cent " + strReste ;
            break;
        default :
            if (byReste == 0)
                NumCent = TabUnit[byCent] + " cents" ;
            else 
                NumCent = TabUnit[byCent] + " cent " + strReste ;
	}
	return NumCent;
}

function hashCode(str) {
    return str.split('').reduce((prevHash, currVal) =>
      (((prevHash << 5) - prevHash) + currVal.charCodeAt(0))|0, 0);
  }
  