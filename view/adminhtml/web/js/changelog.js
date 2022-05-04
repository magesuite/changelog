define([
    'jquery',
    'mage/translate',
    'moment',
    'mage/calendar'
], function ($, t,  moment) {
    "use strict";
    return function (config) {
        const fromPicker = $('#from-picker');
        const toPicker = $('#to-picker');

        const uiDatePickerTrigger = $(".ui-datepicker-trigger");
        $(document).ready(function () {

            $('#Changelog').css('background', 'none');

            fromPicker.datetimepicker({dateFormat: "yy-mm-dd"});
            uiDatePickerTrigger.removeAttr("style");
            uiDatePickerTrigger.click(function () {
                fromPicker.focus();
            });

            toPicker.datetimepicker({dateFormat: "mm/dd/yy"});
            uiDatePickerTrigger.removeAttr("style");
            uiDatePickerTrigger.click(function () {
                toPicker.focus();
            });

            const from = moment().subtract(7, 'days').format('YYYY-MM-DD');
            const to = moment().format('YYYY-MM-DD');
            fromPicker.val(from);
            toPicker.val(to);

            fromPicker.attr('disabled', 'disabled');
            jQuery('#changelog-to input').addClass('disabled')

            toPicker.attr('disabled', 'disabled');
            jQuery('#changelog-from input').addClass('disabled')
        });

        $('#time-helper').on('change', function(){
            let dateFrom = '';
            let dateTo = '';

            const changelogToInput =  $('#changelog-to input');
            const changelogFromInput =  $('#changelog-from input');
            const chosenOption = $("#time-helper option:selected" ).val();

            let disabled = true;

            switch(chosenOption){
                case 'last_week':
                    dateFrom = moment().utc().subtract(7, 'days').format('YYYY-MM-DD');
                    dateTo = moment().utc().format('YYYY-MM-DD');
                    break;
                case 'last_month':
                    dateFrom = moment().utc().subtract(1, 'month').format('YYYY-MM-DD');
                    dateTo = moment().utc().format('YYYY-MM-DD');
                    break;
                case 'last_year':
                    dateFrom = moment().utc().subtract(1, 'year').format('YYYY-MM-DD');
                    dateTo = moment().utc().format('YYYY-MM-DD');
                    break;

                case 'last_deployment':
                    dateFrom = moment().utc().format(config.lastDeploymentDate,'YYYY-MM-DD');
                    dateTo = moment().utc().format('YYYY-MM-DD');
                    break;

                case 'custom_range':
                    dateTo = moment().utc().format('YYYY-MM-DD');
                    disabled = false;
                    $('#changelog-from button').click();
                    break;
                default:
                    console.log('Incorrect selection.');
            }

            if(disabled){
                fromPicker.attr('disabled', 'disabled');
                changelogToInput.addClass('disabled')

                toPicker.attr('disabled', 'disabled');
                changelogFromInput.addClass('disabled')
            } else {
                fromPicker.removeAttr('disabled');
                changelogToInput.removeClass('disabled')

                toPicker.removeAttr('disabled');
                changelogFromInput.removeClass('disabled')
            }
            fromPicker.val(dateFrom);
            toPicker.val(dateTo);
        });

        $('#get-changelog-button').on('click', function () {

            const mode = $("input:radio[name ='mode']:checked").val();

            $.ajax({
                type: "GET",
                url: config.baseChangelogUrl+'mode/'+mode+'/from/'+$('#from-picker').val()+'/to/'+$('#to-picker').val(),
                showLoader: true,
            }).done(function (results) {
                if (results.status !== false) {
                    if(mode==='grouped') {
                        renderResults(results)
                    } else {
                        renderTimeline(results)
                    }
                } else {
                    console.log('Failed to fetch changelog data.')
                }
            }).fail(function () {
                console.log('Failed to fetch changelog data.');
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

            jQuery.each(json, function(key, val) {
                html += '<div class="changelog-module timeline">'
                        +'<span class="date">'+val.version_date+'</span>: '+val.module+' '+getIconForChangeType(val.change_type)+' '+val.change_overview+
                    '</div>'
            });
            html += '</div>';

            let deploymentMarker = '<div class="changelog-module timeline deployment">- DEPLOYMENT ('+config.lastDeploymentDate+') -</div>';
            jQuery('#changelog-content').html(html);

            let marked = false;
            jQuery('div.timeline').each(function(i,el){
                const changeDate = jQuery(el).find('span.date').text();
                if(changeDate < config.lastDeploymentDate && !marked){
                    jQuery(deploymentMarker).insertBefore(el)
                    marked = true;
                }
            });
        }

        function renderResults(json){
            let html = '<div class="changelog-wrapper">';

            let descriptions = [];
            let dates = [];
            let links = [];

            jQuery.each(json, function(key, val) {

                let moduleHtml = '<div class="changelog-module"><div class="module-header"><span class="module-name">'+key+'</span>' +
                    '<span onclick="" class="module-info link">?</span>' +
                    '<span class="module-description"></span></div><div class="module-content">';

                jQuery.each(val, function(version, changes){
                    let versionHtml = '<div class="changelog-version"><span class="version-wrapper">'+version+'</span><span class="tag-date" id="tag_'+key+'"></span></div>';
                    jQuery.each(changes, function(i, change){
                      let changeHtml = '<div class="changelog-change">'+getIconForChangeType(change.change_type)+' '+change.change_overview;
                      if(change.ticket_id != ''){
                          let ticketUrl = '';
                          if(config.trackerUrl.length){
                              ticketUrl = 'style="cursor: pointer;" onclick="window.open(\''+config.trackerUrl+change.ticket_id+'\')" ';
                          }
                          changeHtml += '<span class="ticket" '+ticketUrl+'>'+change.ticket_id+'</span>';
                      }

                      if(change.change_url){
                          changeHtml += '<a href="'+change.change_url+'" target="_blank"><span class="see-more">See more</span></a>';
                      }

                      descriptions[key] = change.description;
                      links[key] = change.url;
                      dates['tag_'+key] = change.version_date;

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

            for (let key in descriptions) {
                if (!descriptions.hasOwnProperty(key)) {
                    continue;
                }

                const extensionHeader = $('div.module-header:contains("' + key + '")');
                extensionHeader.find('span.module-description').html(descriptions[key])
                extensionHeader.find('span.link').attr('onclick', 'window.open("'+links[key]+'")');
            }

            for (let key in dates) {
                if (!dates.hasOwnProperty(key)) {
                    continue;
                }

                jQuery('#'+key).html(dates[key])
            }
        }
    }
});
