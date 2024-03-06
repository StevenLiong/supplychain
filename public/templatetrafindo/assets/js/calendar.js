'use strict';
(function (jQuery) {
    function changeView(value) {
        switch (value) {
            case 'month':
                window.cal.changeView('month', true);
                break;
        }
    }

    function randerRangeText() {
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        const startDate = window.cal.getDateRangeStart()
        const endDate = window.cal.getDateRangeEnd()
        const year = startDate.getFullYear()
        const month = months[startDate.getMonth()]
        console.log(window.cal.getDateRangeEnd())
        console.log(month, year)
        console.log('cal-range-render')
    }

    function createSchedule(){
        window.cal.createSchedules([
            {
                id: '1',
                calendarId: '2',
                title: 'Meeting of design team',
                category: 'time',
                bgColor: '#F35421',
                color: '#ffffff',
                borderColor: '#DA4701',
                dueDateClass: '',
                start: '2024-03-01',
                end: '2024-03-01'
            },
        ])  
    }

    window.cal = new tui.Calendar('#calendar', {
        defaultView: 'month',
        taskView: true,
        template: {
            monthDayname: function(dayname) {
                return '<span class="calendar-week-dayname-name">' + dayname.label + '</span>';
            }
        }
    });
    window.addEventListener('resize', function() {
        window.cal.render();
    });
    $('#cal-type').on('change', function() {
        changeView($(this).val())
    })
    $('#cal-next').on('click', function() {
        window.cal.next()
    })

    $('#cal-prev').on('click', function() {
        window.cal.prev()
    })
    console.log(randerRangeText())
    createSchedule();
})(jQuery);