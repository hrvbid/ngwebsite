/**
 * @version $Id: phpws_addon.js 7816 2010-11-10 17:52:08Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

var pickroute = 0;
var phpws_url = '';
var pathToImages = source + 'javascript/js_calendar/images/';


function forwardit()
{
    url = phpws_url + '&jdate=' + returnDateTo.value;
    window.location.href = url;
}

function displayCalendarPick(month, day, year, url, buttonObj)
{
    calendarDisplayTime = false;
    phpws_url = url;
    pickroute = 1;
    currentYear = inputYear = year;
    currentDay = inputDay = day;
    currentMonth = inputMonth = month - 1;

    if(!calendarDiv){
        initCalendar();
    }else{
        writeCalendarContent();
    }
    returnFormat = 'yyyymmdd'

    returnDateTo = new Object();
    returnDateTo.value = '';
    returnDateTo.onchange = forwardit;
    positionCalendar(buttonObj);
    calendarDiv.style.visibility = 'visible';
    calendarDiv.style.display = 'block';
    if(iframeObj){
        iframeObj.style.display = '';
        iframeObj.style.height = '140px';
        iframeObj.style.width = '195px';
    }
    setTimeProperties();
    updateYearDiv();
    updateMonthDiv();
    calendarDisplayTime = false;
}
