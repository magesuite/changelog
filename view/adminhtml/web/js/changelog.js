define([
    'jquery',
    'moment',
    'mage/calendar',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'domReady!'
], function ($, moment, calendar, modal) {
    "use strict";
    var options = {
        type: 'slide',
        responsive: true,
        innerScroll: true,
        buttons: [{
            text: $.mage.__('Continue'),
            class: 'primary action submit btn btn-default',
            click: function () {
                this.closeModal();
            }
        }]
    };
    return function (config) {
        const $fromPicker = $('#from-picker');
        const $toPicker = $('#to-picker');

        const $changelogDatePickerBtn = $(".changelog-datepicker-btn");
        const $changelogToInput =  $('#changelog-to input');
        const $changelogFromInput =  $('#changelog-from input');

        $('#Changelog').css('background', 'none');

        $fromPicker.datetimepicker({dateFormat: "yy-mm-dd"});
        $toPicker.datetimepicker({dateFormat: "yy-mm-dd"});
        $changelogDatePickerBtn.removeAttr("style");
        
        $changelogDatePickerBtn.each(function(){
            $(this).on('click', function() {
                $(this).prev().focus();
            });
        });

        const from = moment().subtract(7, 'days').format('YYYY-MM-DD');
        const to = moment().format('YYYY-MM-DD');
        $fromPicker.val(from);
        $toPicker.val(to);

        $fromPicker.attr('disabled', 'disabled');
        $changelogToInput.addClass('disabled')

        $toPicker.attr('disabled', 'disabled');
        $changelogFromInput.addClass('disabled');

        $('#time-helper').on('change', function(){
            const $changelogToInput =  $('#changelog-to input');
            const $changelogFromInput =  $('#changelog-from input');

            let dateFrom = '';
            let dateTo = '';

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
                $fromPicker.attr('disabled', 'disabled');
                $changelogToInput.addClass('disabled')

                $toPicker.attr('disabled', 'disabled');
                $changelogFromInput.addClass('disabled')
            } else {
                $fromPicker.removeAttr('disabled');
                $changelogToInput.removeClass('disabled')

                $toPicker.removeAttr('disabled');
                $changelogFromInput.removeClass('disabled')
            }
            $fromPicker.val(dateFrom);
            $toPicker.val(dateTo);
        });

        $('#download-changelog-button').on('click', function (){
            const mode = $("input:radio[name ='mode']:checked").val();
            window.location = config.baseDownloadChangelogUrl+'mode/grouped/from/'+$fromPicker.val()+'/to/'+$toPicker.val();
        });

        $('#get-changelog-button').on('click', function () {

            const mode = $("input:radio[name ='mode']:checked").val();

            $.ajax({
                type: "GET",
                url: config.baseChangelogUrl+'mode/'+mode+'/from/'+$fromPicker.val()+'/to/'+$toPicker.val(),
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

            $.each(json, function(i, val) {
                html += '<div class="changelog-module timeline">'
                        +'<span class="date">'+val.version_date+'</span>: '+val.module+' '+getIconForChangeType(val.change_type)+' '+val.change_overview+
                    '</div>'
            });
            html += '</div>';

            const deploymentMarker = '<div class="changelog-module timeline deployment">- DEPLOYMENT ('+moment().utc().format(config.lastDeploymentDate,'YYYY-MM-DD')+') -</div>';
            $('#changelog-content').html(html);

            let marked = false;
            $('div.timeline').each(function(i, el){
                const changeDate = $(el).find('span.date').text();
                if(changeDate < config.lastDeploymentDate && !marked){
                    $(deploymentMarker).insertBefore(el)
                    marked = true;
                }
            });
        }
        function preview(reference){
            alert(reference)
        }
        function renderResults(json){
            let html = '<div class="changelog-wrapper">';

            const descriptions = [];
            const dates = [];
            const links = [];

            $.each(json, function(key, val) {

                let moduleHtml = '<div class="changelog-module"><div class="module-header"><span class="module-name">'+key+'</span>' +
                    '<span onclick="" class="module-info link">?</span>' +
                    '<span class="module-description"></span></div><div class="module-content">';

                $.each(val, function(version, changes){
                    let versionHtml = '<div class="changelog-version"><span class="version-wrapper">'+version+'</span><span class="tag-date" id="tag_'+key+'"></span></div>';
                    $.each(changes, function(i, change){
                      let changeHtml = '<div class="changelog-change">'+getIconForChangeType(change.change_type)+' '+change.change_overview;

                      if(change.ticket_id != ''){
                          let ticketUrl = '';
                          if(config.trackerUrl.length){
                              ticketUrl = 'style="cursor: pointer;" onclick="window.open(\''+config.trackerUrl+change.ticket_id+'\')" ';
                          }
                          changeHtml += '<span class="ticket" '+ticketUrl+'>'+change.ticket_id+'</span>';
                      }

                      if(change.doc_reference != ''){
                          changeHtml += '<span class="ticket reference-button" reference="'+change.doc_reference+'" class="ticket">TELL ME MORE!</span>';
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

            $('#changelog-content').html(html);

            $('.reference-button').on("click", function(){
                $.ajax({
                    url:config.markdownPreviewUrl,
                    type:'POST',
                    showLoader: true,
                    dataType: 'json',
                    data: {
                        filename: $(this).attr('reference')
                    },
                    complete: function(data) {
                        $('.modal-body-content p').html(data.responseText);
                        $("#modal").modal(options).modal('openModal');
                    },
                    error: function (xhr, status, errorThrown) {
                        console.log('Error: ', errorThrown);
                    }
                });
            })
            for (const key in descriptions) {
                if (!descriptions.hasOwnProperty(key)) {
                    continue;
                }

                const $extensionHeader = $('div.module-header:contains("' + key + '")');
                $extensionHeader.find('span.module-description').html(descriptions[key])
                $extensionHeader.find('span.link').attr('onclick', 'window.open("'+links[key]+'")');
            }

            for (const key in dates) {
                if (!dates.hasOwnProperty(key)) {
                    continue;
                }

                $('#'+key).html(dates[key])
            }
        }
    }
});
