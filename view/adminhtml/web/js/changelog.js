define([
    'jquery',
    'mage/translate',
    'https://www.gstatic.com/charts/loader.js',
    'moment',
    'mage/calendar'
], function ($, t, g, moment) {
    "use strict";
    return function (config) {

        let fromPicker = $('#from-picker');
        let toPicker = $('#to-picker');


        $(document).ready(function () {

            $('#Changelog').css('background', 'none');

            fromPicker.datetimepicker({dateFormat: "yy-mm-dd"});
            $(".ui-datepicker-trigger").removeAttr("style");
            $(".ui-datepicker-trigger").click(function () {
                fromPicker.focus();
            });

            toPicker.datetimepicker({dateFormat: "mm/dd/yy"});
            $(".ui-datepicker-trigger").removeAttr("style");
            $(".ui-datepicker-trigger").click(function () {
                toPicker.focus();
            });

            let from = moment().subtract(7, 'days').format('YYYY-MM-DD');
            let to = moment().format('YYYY-MM-DD');
            fromPicker.val(from);
            toPicker.val(to);

            fromPicker.attr('disabled', 'disabled');
            jQuery('#historic-to input').addClass('disabled')

            toPicker.attr('disabled', 'disabled');
            jQuery('#historic-from input').addClass('disabled')
        });

        $('#time-helper').on('change', function(){
            let dateFrom = '';
            let dateTo = '';

            let chosenOption = $("#time-helper option:selected" ).val();

            let disabled = true;
            if(chosenOption=='last_week'){
                dateFrom = moment().utc().subtract(7, 'days').format('YYYY-MM-DD');
                dateTo = moment().utc().format('YYYY-MM-DD');
            }
            if(chosenOption=='last_month'){
                dateFrom = moment().utc().subtract(1, 'month').format('YYYY-MM-DD');
                dateTo = moment().utc().format('YYYY-MM-DD');
            }
            if(chosenOption=='last_year'){
                dateFrom = moment().utc().subtract(1, 'year').format('YYYY-MM-DD');
                dateTo = moment().utc().format('YYYY-MM-DD');
            }
            if(chosenOption=='last_deployment'){
                dateFrom = moment().utc().subtract(1, 'month').format('YYYY-MM-DD');
                dateTo = moment().utc().format('YYYY-MM-DD');
            }
            if(chosenOption=='custom_range'){
                dateTo = moment().utc().format('YYYY-MM-DD');
                disabled = false;
                $('#historic-from button').click();
            }

            if(disabled){
                fromPicker.attr('disabled', 'disabled');
                jQuery('#historic-to input').addClass('disabled')

                toPicker.attr('disabled', 'disabled');
                jQuery('#historic-from input').addClass('disabled')
            } else {

                fromPicker.removeAttr('disabled');
                jQuery('#historic-to input').removeClass('disabled')

                toPicker.removeAttr('disabled');
                jQuery('#historic-from input').removeClass('disabled')
            }
            fromPicker.val(dateFrom);
            toPicker.val(dateTo);


        });

        $('#apply-historic-stats').on('click', function () {

            let mode = $("input:radio[name ='mode']:checked").val();
            /* Init charts */
            $.ajax({
                type: "GET",
                url: config.baseChangelogUrl+'mode/'+mode,
                showLoader: true,
            }).done(function (results) {
                if (results.status !== false) {
                    if(mode=='grouped') {
                        renderResults(results)
                    } else {
                        renderTimeline(results)
                    }
                } else {
                    alert('failed');
                }
            }).fail(function () {

            });

        });

        function getIconForChangeType(type){

            switch(type){
                case 'FEATURE':
                    return '🌟';
                    break;
                case 'FIX':
                    return '🕷';
                    break;
                case 'SECURITY':
                    return '🔑';
                    break;
                case 'PERFORMANCE':
                    return '⚡️';
                    break;
                case 'INIT':
                    return '🐣';
                    break;
                case 'STYLE':
                    return '🎨'
                break;
                default:
                    return '➡️'
            }

        }

        function renderTimeline(json){
            let html = '<div class="changelog-wrapper">';
            let i = 0;
            jQuery.each(json, function(key, val) {
                i++;
                html += '<div class="changelog-module timeline">'+val.version_date+': '+val.module+' '+getIconForChangeType(val.change_type)+' '+val.change_overview+'</div>'
                if(i%5==0)html += '<div class="changelog-module timeline deployment">- DEPLOYMENT (13.03.2021) -</div>';
            });
            html += '</div>';

            jQuery('#changelog-content').html(html);
        }

        function renderResults(json){
            let html = '<div class="changelog-wrapper">';
            let descriptions = [];
            let dates = [];
            let v=0;
            jQuery.each(json, function(key, val) {
                let moduleHtml = '<div class="changelog-module"><div class="module-header"><span class="module-name">'+key+'</span>' +
                    '<span class="module-info">?</span>' +
                    '<span class="module-description"></span></div><div class="module-content">';

                jQuery.each(val, function(version, changes){
                    v++;
                    let versionHtml = '<div class="changelog-version"><span class="version-wrapper">'+version+'</span><span class="tag-date" id="tag_'+v+'"></span></div>';
                    jQuery.each(changes, function(i, change){
                      let changeHtml = '<div class="changelog-change">'+getIconForChangeType(change.change_type)+' '+change.change_overview;
                      if(change.ticket_id != ''){
                          let ticketUrl = '';
                          if(config.trackerUrl.length){
                              ticketUrl = 'style="cursor: pointer;" onclick="window.open(\''+config.trackerUrl+change.ticket_id+'\')" ';
                          }
                          changeHtml += '<span class="ticket" '+ticketUrl+'>'+change.ticket_id+'</span>';
                      }


                      descriptions[key] = change.description;
                      dates['tag_'+v] = change.version_date;

                      changeHtml += '</div>';
                      versionHtml += changeHtml;
                    })
                    moduleHtml += versionHtml;
                });

                moduleHtml += '</div></div>';

                html += moduleHtml;
            });

            html += '</div>';

            jQuery('#changelog-content').html(html);

            for (var index in descriptions) {
                if (!descriptions.hasOwnProperty(index)) {
                    continue;
                }

                jQuery('div.module-header:contains("' + index + '")').find('span.module-description').html(descriptions[index])
            }

            for (var index in dates) {
                if (!dates.hasOwnProperty(index)) {
                    continue;
                }

                jQuery('#'+index).html(dates[index])
            }
        }
    }
});
