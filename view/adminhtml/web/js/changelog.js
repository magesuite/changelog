define([
    'jquery',
    'mage/translate',
    'moment',
    'mage/calendar'
], function ($, t,  moment) {
    "use strict";
    return function (config) {
        console.log(config);
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
            jQuery('#changelog-to input').addClass('disabled')

            toPicker.attr('disabled', 'disabled');
            jQuery('#changelog-from input').addClass('disabled')
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
                dateFrom = moment().utc().format(config.lastDeploymentDate,'YYYY-MM-DD');
                dateTo = moment().utc().format('YYYY-MM-DD');
            }
            if(chosenOption=='custom_range'){
                dateTo = moment().utc().format('YYYY-MM-DD');
                disabled = false;
                $('#changelog-from button').click();
            }

            if(disabled){
                fromPicker.attr('disabled', 'disabled');
                jQuery('#changelog-to input').addClass('disabled')

                toPicker.attr('disabled', 'disabled');
                jQuery('#changelog-from input').addClass('disabled')
            } else {

                fromPicker.removeAttr('disabled');
                jQuery('#changelog-to input').removeClass('disabled')

                toPicker.removeAttr('disabled');
                jQuery('#changelog-from input').removeClass('disabled')
            }
            fromPicker.val(dateFrom);
            toPicker.val(dateTo);


        });

        $('#get-changelog-button').on('click', function () {

            let mode = $("input:radio[name ='mode']:checked").val();

            $.ajax({
                type: "GET",
                url: config.baseChangelogUrl+'mode/'+mode+'/from/'+$('#from-picker').val()+'/to/'+$('#to-picker').val(),
                showLoader: true,
            }).done(function (results) {
                if (results.status !== false) {
                    if(mode=='grouped') {
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
            let i = 0;
            jQuery.each(json, function(key, val) {
                i++;
                html += '<div class="changelog-module timeline">'
                        +'<span class="date">'+val.version_date+'</span>: '+val.module+' '+getIconForChangeType(val.change_type)+' '+val.change_overview+
                    '</div>'
            });
            html += '</div>';

            let deploymentMarker = '<div class="changelog-module timeline deployment">- DEPLOYMENT ('+config.lastDeploymentDate+') -</div>';


            jQuery('#changelog-content').html(html);

            var marked = false;
            jQuery('div.timeline').each(function(i,el){
                let changeDate = jQuery(el).find('span.date').text();
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

            let v=0;
            jQuery.each(json, function(key, val) {

                let moduleHtml = '<div class="changelog-module"><div class="module-header"><span class="module-name">'+key+'</span>' +
                    '<span onclick="" class="module-info link">?</span>' +
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

                      if(change.change_url){
                          changeHtml += '<a href="'+change.change_url+'" target="_blank"><span class="see-more">See more</span></a>';
                      }

                      descriptions[key] = change.description;
                      links[key] = change.url;
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
                jQuery('div.module-header:contains("' + index + '")').find('span.link').attr('onclick', 'window.open("'+links[index]+'")');
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
