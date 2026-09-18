$(document).ready(function () {
    $(".classic-menu-dropdown").hover(
      function () {
          $(this).addClass("open");
      }, function () {
          $(this).removeClass("open");
      }
    );
    var menuHtml = $('.page-sidebar-menu li.active,.navbar-nav li.active').html();
    $('#breadCrumb').html(menuHtml);
    $('#breadCrumb').find('ul:first').addClass('dropdown-menu pull-left');
    $('#breadCrumb').find('a:first').css('display', 'unset');
});

function addStyle() {
    //debugger;
    var w = $('.portlet-title').width();
    var h = $('.header-height').height();
    var menuType = $('select[name=ddlHeader],select[name=ddlTopMenuMode]').val();
    var megaMenuType = $('select[name=ddlMegaMenuMode]').val();
    $('#dvHeader').width(w + 20);
    if (menuType == 'fixed') {
        $('#dvHeader').css('position', 'fixed').css('top', h).css('z-index', '10000');
    }
    else if (megaMenuType == 'fixed')
    {
        h = $('.page-header-menu').height();
        $('#dvHeader').css('position', 'fixed').css('top', h).css('z-index', '10000');
    }
    else {
        $('#dvHeader').css('position', 'fixed').css('top', '0').css('z-index', '10000');
    }
}

function removeStyle() {
    $('#dvHeader').css('position', '').css('top', '').css('z-index', '');
}

function sticky_relocate() {
    var window_top = $(window).scrollTop();
    var div_top = $('#sticky-anchor').offset().top;
    if (window_top > div_top) {
        addStyle();
    } else {
        removeStyle();
    }
}
$(function () {
    $(window).scroll(sticky_relocate);
    sticky_relocate();
});

