/* var EA = document.querySelector('.EA');
console.log(EA.val());*/

// Select elements by their data attribute
const $energysmartmeterEntryElements = $('[data-entry-idenergysmartmeter]');

// Map over each element and extract the data value
const $energysmartmeterEntryIds = $.map($energysmartmeterEntryElements, item => $(item).data('entryIdenergysmartmeter'));
//$('.gridTab td').eq(7).html('1.5');
// You'll now have array containing string values
//console.log($energysmartmeterEntryIds[0]); // eg: ["1", "2", "3"]

// Select elements by their data attribute
const $fuelEntryElements = $('[data-entry-idfuel]');

// Map over each element and extract the data value
const $fuelEntryIds = $.map($fuelEntryElements, item => $(item).data('entryIdfuel'));
//$('.fuelTab td').eq(7).html('0.7');
// You'll now have array containing string values
//console.log(Object.values($fuelEntryIds)); // eg: ["1", "2", "3"]


// Select elements by their data attribute
const $stocklinkEntryElements = $('[data-entry-stocklink]');

// Map over each element and extract the data value
const $stocklinkEntry = $.map($stocklinkEntryElements, item => $(item).data('entryStocklink'));
//$('.stocklinkTab td').eq(7).html('0.7');
// You'll now have array containing string values
//console.log(Object.values($stocklinkEntry)); // eg: ["1", "2", "3"]
var tabFuelStockLink = [];
$fuelEntryIds.forEach(function (item, index) {
    //$('.fuelTab td').eq(index * 7 + 1).html(data.EA[item] === null ? 0 : data.EA[item]); //EA
    tabFuelStockLink[item] = $stocklinkEntry[index];
});
//console.log(tabFuelStockLink["11"]);
//console.log($('#fuelStockLink').attr("href"));


var tabEnergySmartMeterId = [];
var tabFuelId = [];
var strEnergySmartMeterId = '';
var strFuelModId = '';

var d = new Date();
var timeZoneOffset = d.getTimezoneOffset();
timeZoneOffset = timeZoneOffset / (-60);
//console.log('Date : ' + d);
//console.log(moment().format('zz'));
//console.log('TimeZone offset : ' + timeZoneOffset);


$("#datetimepicker10").on("dp.change", function (e) {
    //$('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    //console.log(e.date._d.toLocaleString().replace('à', ''));
    //console.log(e.date._d);
    //$date = new Date(e.date._d);
    //console.log(e.date.format("YYYY-MM-DD H:i:s")._d);
    //console.log(Date.parse($date).toString('yyyy-MM-dd H:i:s'));
    // +++++++++ Récupération de l'id du module Grid sélectionné' +++++++++
    strEnergySmartMeterId = String($("#selectEnergySmartMeter").children(":selected").attr("id"));
    strEnergySmartMeterId = strEnergySmartMeterId.substring(strEnergySmartMeterId.indexOf('_') + 1);

    // +++++++++ Récupération de l'id du module Fuel sélectionné' +++++++++
    strFuelModId = String($("#selectFuelMod").children(":selected").attr("id"));
    strFuelModId = strFuelModId.substring(strFuelModId.indexOf('_') + 1);
    //console.log('Fuel selected option id : ' + strFuelModId);
    //console.log('Grid selected option id : ' + strEnergySmartMeterId);
    tabEnergySmartMeterId = [];
    tabFuelId = [];
    tabEnergySmartMeterId = [parseInt(strEnergySmartMeterId)];
    tabFuelId = [parseInt(strFuelModId)];
    //console.log(tabEnergySmartMeterId);
    //console.log(tabFuelId);

    // +++++++++ Récupération de la date sélectionnée +++++++++
    //console.log($("#datetimepicker10").data("DateTimePicker"));
    //console.log($('#datetimepicker10').data('DateTimePicker').date()._d);
    $dat = new moment(e.date._d);
    $date = $dat.format("YYYY-MM").toString();
    //console.log($date);
    $date = '%' + $date + '%';
    //console.log($date);
    var $data = JSON.stringify({
        "energySmartMeterIds": $energysmartmeterEntryIds,//tabEnergySmartMeterId,
        //"fuelIds": $fuelEntryIds,//tabFuelId,
        "selectedEnergySmartMeterId": parseInt(strEnergySmartMeterId),
        //"selectedfuelId": parseInt(strFuelModId),
        "selectedDate": $date
    });
    //console.log($data);
    $('.card-preloader').fadeIn();
    updateDataTable($data, $urlupdateDashMeter, true);

});

$("#selectEnergySmartMeter").change(function () {
    //console.log('selected GRID option : ' + $(this).val());
    // +++++++++ Récupération de l'id du module Grid sélectionné' +++++++++
    strEnergySmartMeterId = String($(this).children(":selected").attr("id"));
    strEnergySmartMeterId = strEnergySmartMeterId.substring(strEnergySmartMeterId.indexOf('_') + 1);

    // +++++++++ Récupération de l'id du module Fuel sélectionné' +++++++++
    strFuelModId = String($("#selectFuelMod").children(":selected").attr("id"));
    strFuelModId = strFuelModId.substring(strFuelModId.indexOf('_') + 1);
    //console.log('Fuel selected option id : ' + strFuelModId);
    //console.log('Grid selected option id : ' + strEnergySmartMeterId);
    tabEnergySmartMeterId = [];
    tabFuelId = [];
    tabEnergySmartMeterId = [parseInt(strEnergySmartMeterId)];
    tabFuelId = [parseInt(strFuelModId)];
    //console.log(tabEnergySmartMeterId);
    //console.log(tabFuelId);

    // +++++++++ Récupération de la date sélectionnée +++++++++
    //console.log($("#datetimepicker10").data("DateTimePicker"));
    //console.log($('#datetimepicker10').data('DateTimePicker').date()._d);
    $dat = new moment($("#datetimepicker10").data('DateTimePicker').date()._d);
    $date = $dat.format("YYYY-MM").toString();
    //console.log($date);
    $date = '%' + $date + '%';
    //console.log($date);
    var $data = JSON.stringify({
        "energySmartMeterIds": tabEnergySmartMeterId,
        // "fuelIds": tabFuelId,
        "selectedEnergySmartMeterId": parseInt(strEnergySmartMeterId),
        // "selectedfuelId": parseInt(strFuelModId),
        "selectedDate": $date
    });
    $('#select-preloader .card-preloader').fadeIn();
    updateDataTable($data, $urlupdateDashMeter, false);
});

strFuelModId = String($("#selectFuelMod").children(":selected").attr("id"));
strFuelModId = strFuelModId.substring(strFuelModId.indexOf('_') + 1);
$('#fuelStockLink').attr("href", tabFuelStockLink[strFuelModId]); // Set herf value

$("#selectFuelMod").change(function () {
    //console.log('selected Fuel option : ' + $(this).val());
    // +++++++++ Récupération de l'id du module Fuel sélectionné' +++++++++
    strFuelModId = String($(this).children(":selected").attr("id"));
    strFuelModId = strFuelModId.substring(strFuelModId.indexOf('_') + 1);

    // +++++++++ Récupération de l'id du module Grid sélectionné' +++++++++
    strEnergySmartMeterId = String($("#selectEnergySmartMeter").children(":selected").attr("id"));
    strEnergySmartMeterId = strEnergySmartMeterId.substring(strEnergySmartMeterId.indexOf('_') + 1);
    //console.log('Fuel selected option id : ' + strFuelModId);
    //console.log('Grid selected option id : ' + strEnergySmartMeterId);
    tabEnergySmartMeterId = [];
    tabFuelId = [];
    tabEnergySmartMeterId = [parseInt(strEnergySmartMeterId)];
    tabFuelId = [parseInt(strFuelModId)];
    //console.log(tabEnergySmartMeterId);
    //console.log(tabFuelId);

    $('#fuelStockLink').attr("href", tabFuelStockLink[strFuelModId]); // Set herf value

    // +++++++++ Récupération de la date sélectionnée +++++++++
    //console.log($("#datetimepicker10").data("DateTimePicker"));
    //console.log($('#datetimepicker10').data('DateTimePicker').date()._d);
    $dat = new moment($("#datetimepicker10").data('DateTimePicker').date()._d);
    $date = $dat.format("YYYY-MM").toString();
    //console.log($date);
    $date = '%' + $date + '%';
    //console.log($date);
    var $data = JSON.stringify({
        "energySmartMeterIds": tabEnergySmartMeterId,
        // "fuelIds": tabFuelId,
        "selectedEnergySmartMeterId": parseInt(strEnergySmartMeterId),
        // "selectedfuelId": parseInt(strFuelModId),
        "selectedDate": $date
    });
    //console.log($data);
    $('.spinFuelDetailed').removeClass('d-none');
    $('.spinGridTab').addClass('d-none');
    $('.spinGridDetailed').addClass('d-none');
    $('.spinFuelTab').addClass('d-none');
    $("#datatable3").css({ opacity: 0.2 });
    updateDataTable($data, $urlupdateDashMeter, false);
});


$('select').on('change', function () {
    //console.log('selected option : ' + this.value);
    //console.log('selected option id : ' + $(this).attr('id'));
});

function progressVal(selectorVal, selectorIcon, prog, posLogique, isTime) {
    var DESC = 'mdi-menu-down';
    var ASC = 'mdi-menu-up';
    var greenColor = 'text-success';
    var redColor = 'text-danger';
    if (!isTime) {
        selectorVal.html(prog === null ? 0 : prog > 0 ? '+' + prog.toFixed(1) : prog.toFixed(1));
    }
    else {
        var diff = new Date(Math.abs(prog));
        var $dat = new moment(diff).subtract(timeZoneOffset, 'hours');
        var str = $dat.format('HH:mm:ss').toString()
        selectorVal.html(prog === null ? 0 : prog > 0 ? '+' + str : '-' + str);
    }
    if (posLogique) {
        if (prog > 0) {
            selectorIcon.removeClass(DESC).addClass(ASC);
            selectorIcon.removeClass(greenColor).addClass(redColor);
            /*if (selectorIcon.hasClass(oldClass)) {
                // it has class
            } else {
                // it doesn't have specified class
            }*/
        }
        else {
            selectorIcon.removeClass(ASC).addClass(DESC);
            selectorIcon.removeClass(redColor).addClass(greenColor);
        }
    }
    else {
        if (prog > 0) {
            selectorIcon.removeClass(DESC).addClass(ASC);
            selectorIcon.removeClass(redColor).addClass(greenColor);
            /*if (selectorIcon.hasClass(oldClass)) {
                // it has class
            } else {
                // it doesn't have specified class
            }*/
        }
        else {
            selectorIcon.removeClass(ASC).addClass(DESC);
            selectorIcon.removeClass(greenColor).addClass(redColor);
        }
    }
}

function updateDataTable(_data, _url, all) {
    $.ajax({
        type: "POST",//method type
        contentType: "application/json; charset=utf-8",
        url: _url,///Target function that will be return result
        data: _data,//parameter pass data is parameter name param is value 
        dataType: "json",
        timeout: 120000,//64241
        success: function (data) {
            //alert("Success");
            console.log(data);
            //console.log(data.EA[$energysmartmeterEntryIds[0]]);
            //console.log(typeof data.Liters[$fuelEntryIds[0]]);
            //$("#gridEA").text(data.EA[9] === null ? 0 : data.EA[9]);
            $('.card-preloader').fadeOut();
            var $energySmartMeterCost = costComputing(data.tabEA_grid, 2200, 'residential', parseFloat(data.EA[parseInt(strEnergySmartMeterId)]));
            console.log($energySmartMeterCost);
            var $precenergySmartMeterCost = costComputing(data.prectabEA_grid, 2200, 'residential', parseFloat(data.EA[parseInt(strEnergySmartMeterId)]));
            console.log($precenergySmartMeterCost);

            //var $fuelPrice = 575;
            //var $fuelModCost = parseFloat(data.Liters[parseInt(strFuelModId)]) * $fuelPrice;
            //console.log($fuelModCost);
            //var $precfuelModCost = parseFloat(data.precLiters[parseInt(strFuelModId)]) * $fuelPrice;
            //console.log($precfuelModCost);
            /*var $fuelModCost = costComputing(data.tabEA_fuel, 2200, data.subscription, data.EA[parseInt(strFuelModId)]);
            console.log($fuelModCost);
            var $precfuelModCost = costComputing(data.prectabEA_fuel, 2200, data.subscription, data.EA[parseInt(strFuelModId)]);
            console.log($precfuelModCost);*/
            var prog = 0;

            if (all) {
                //tabEnergySmartMeterId.forEach(function (item, index) {

                $energysmartmeterEntryIds.forEach(function (item, index) {
                    //MAJ du tableau récaputilatif des modules GRID
                    //console.log(item);
                    //console.log(typeof item);
                    $('.EnergySmartMeterTabReport td').eq(index * 2 + 1).html(data.EA[item] === null ? 0 : parseFloat(data.EA[item]).toFixed(1)); //EA
                    // $('.gridTabReport td').eq(index * 4 + 2).html(data.ER[item] === null ? 0 : parseFloat(data.ER[item]).toFixed(1)); //ER
                    // $('.gridTabReport td').eq(index * 4 + 3).html(data.Cos[item] === null ? 0 : parseFloat(data.Cos[item]).toFixed(3)); //Cosphi

                    if (item === parseInt(strEnergySmartMeterId)) {
                        //MAJ du tableau détailé des modules GRID
                        $('.EnergySmartMeterTab td').eq(1).html(data.EA[item] === null ? 0 : parseFloat(data.EA[item]).toFixed(1)); //EA
                        $('.EnergySmartMeterTab td').eq(4).html($energySmartMeterCost === null ? 0 : $energySmartMeterCost.toFixed(1)); //Cost
                        // $('.EnergySmartMeterTab td').eq(7).html(data.ER[item] === null ? 0 : parseFloat(data.ER[item]).toFixed(1)); //ER
                        // $('.EnergySmartMeterTab td').eq(10).html(data.Cos[item] === null ? 0 : parseFloat(data.Cos[item]).toFixed(3)); //Cosphi
                        $('.EnergySmartMeterTab td').eq(7).html(data.Pmax[item] === null ? 0 : parseFloat(data.Pmax[item]).toFixed(1)); //Smax
                        $('.EnergySmartMeterTab td').eq(10).html(data.Pmoy[item] === null ? 0 : parseFloat(data.Pmoy[item]).toFixed(1)); //Smoy

                        prog = (parseFloat(data.EA[item]) - parseFloat(data.precEA[item])) * 100 / parseFloat(data.precEA[item]);
                        //$('.gridTab td').eq(2).html(prog === null ? 0 : prog.toFixed(1)); //EA gridEAProgVal
                        progressVal($('#EAProgVal'), $('#EAProg'), prog, true, false);

                        prog = ($energySmartMeterCost - $precenergySmartMeterCost) * 100 / $precenergySmartMeterCost;
                        progressVal($('#CostProgVal'), $('#CostProg'), prog, true, false);

                        // prog = (parseFloat(data.ER[item]) - parseFloat(data.precER[item])) * 100 / parseFloat(data.precER[item]);
                        // progressVal($('#ERProgVal'), $('#ERProg'), prog, true, false); //ER

                        // prog = (parseFloat(data.Cos[item]) - parseFloat(data.precCos[item])) * 100 / parseFloat(data.precCos[item]);
                        // progressVal($('#CosProgVal'), $('#CosProg'), prog, false, false); //Cosphi

                        prog = (parseFloat(data.Pmax[item]) - parseFloat(data.precPmax[item])) * 100 / parseFloat(data.precPmax[item]);
                        progressVal($('#PmaxProgVal'), $('#PmaxProg'), prog, true, false); //Pmax

                        prog = (parseFloat(data.Pmoy[item]) - parseFloat(data.precPmoy[item])) * 100 / parseFloat(data.precPmoy[item]);
                        progressVal($('#PmoyProgVal'), $('#PmoyProg'), prog, true, false); //Pmoy
                    }

                });

                //tabFuelId.forEach(function (item, index) {
                /*$fuelEntryIds.forEach(function (item, index) {
                    //MAJ du tableau récaputilatif des modules FUEL
                    $('.fuelTabReport td').eq(index * 4 + 1).html(data.EA[item] === null ? 0 : parseFloat(data.EA[item]).toFixed(1)); //EA
                    $('.fuelTabReport td').eq(index * 4 + 2).html(data.ER[item] === null ? 0 : parseFloat(data.ER[item]).toFixed(1)); //ER
                    $('.fuelTabReport td').eq(index * 4 + 3).html(data.Cos[item] === null ? 0 : parseFloat(data.Cos[item]).toFixed(3)); //Cosphi

                    //MAJ du tableau détaillé des modules FUEL
                    if (item === parseInt(strFuelModId)) {
                        $('.fuelTab td').eq(1).html(data.EA[item] === null ? 0 : parseFloat(data.EA[item]).toFixed(1)); //EA
                        $('.fuelTab td').eq(4).html($fuelModCost === null ? 0 : $fuelModCost.toFixed(1)); //Cost
                        $('.fuelTab td').eq(7).html(data.Liters[item] === null ? 0 : parseFloat(data.Liters[item]).toFixed(1)); //Liters
                        $('.fuelTab td').eq(10).html(data.WorkingTime[item] === null ? 0 : data.WorkingTime[item]); //Temps de fonctionnement
                        $('.fuelTab td').eq(13).html(data.Cos[item] === null ? 0 : parseFloat(data.Cos[item]).toFixed(3)); //Cosphi
                        //$('.fuelTab td').eq(16).html(data.Stock[item] === null ? 0 : data.Stock[item]); //Stock
                        //console.log(data.workTime);
                        //console.log(data.precworkTime);
                        prog = (parseFloat(data.EA[item]) - parseFloat(data.precEA[item])) * 100 / parseFloat(data.precEA[item]);
                        progressVal($('#fuelEAProgVal'), $('#fuelEAProg'), prog, true, false);

                        //$('.fuelTab td').eq(5).html($fuelModCost === null ? 0 : $fuelModCost); //Cost Progression
                        prog = ($fuelModCost - $precfuelModCost) * 100 / $precfuelModCost;
                        progressVal($('#fuelCostProgVal'), $('#fuelCostProg'), prog, true, false);

                        //console.log(typeof data.Liters[item]);
                        //console.log(data.precLiters[item]);
                        prog = (parseFloat(data.Liters[item]) - parseFloat(data.precLiters[item])) * 100 / parseFloat(data.precLiters[item]);
                        progressVal($('#fuelLitersProgVal'), $('#fuelLitersProg'), prog, true, false); //Liters

                        prog = (parseFloat(data.Cos[item]) - parseFloat(data.precCos[item])) * 100 / parseFloat(data.precCos[item]);
                        progressVal($('#fuelCosProgVal'), $('#fuelCosProg'), prog, false, false); //Cosphi

                        var date = new Date('2020-05-22 ' + data.workTime);
                        var precdate = new Date('2020-05-22 ' + data.precworkTime);
                        var prog = new Date(date - precdate);
                        //prog = (data.WorkingTime[item] - data.precWorkingTime[item]) * 100 / data.precWorkingTime[item];
                        progressVal($('#fuelWorkingTimeProgVal'), $('#fuelWorkingTimeProg'), prog, true, true); //WorkingTime 
                    }

                });*/
            }
            else {

                tabEnergySmartMeterId.forEach(function (item, index) {
                    //MAJ du tableau récaputilatif des modules GRID
                    //console.log(item);
                    //console.log(typeof item);

                    $('.EnergySmartMeterTabReport td').eq(index * 2 + 1).html(data.EA[item] === null ? 0 : parseFloat(data.EA[item]).toFixed(1)); //EA
                    // $('.EnergySmartMeterTabReport td').eq(index * 2 + 2).html(data.ER[item] === null ? 0 : parseFloat(data.ER[item]).toFixed(1)); //ER
                    // $('.EnergySmartMeterTabReport td').eq(index * 2 + 3).html(data.Cos[item] === null ? 0 : parseFloat(data.Cos[item]).toFixed(3)); //Cosphi

                    if (item === parseInt(strEnergySmartMeterId)) {
                        //MAJ du tableau détailé des modules GRID
                        $('.EnergySmartMeterTab td').eq(1).html(data.EA[item] === null ? 0 : parseFloat(data.EA[item]).toFixed(1)); //EA
                        $('.EnergySmartMeterTab td').eq(4).html($energySmartMeterCost === null ? 0 : $energySmartMeterCost.toFixed(1)); //Cost
                        // $('.EnergySmartMeterTab td').eq(7).html(data.ER[item] === null ? 0 : parseFloat(data.ER[item]).toFixed(1)); //ER
                        // $('.EnergySmartMeterTab td').eq(10).html(data.Cos[item] === null ? 0 : parseFloat(data.Cos[item]).toFixed(3)); //Cosphi
                        $('.EnergySmartMeterTab td').eq(7).html(data.Pmax[item] === null ? 0 : parseFloat(data.Pmax[item]).toFixed(1)); //Smax
                        $('.EnergySmartMeterTab td').eq(10).html(data.Pmoy[item] === null ? 0 : parseFloat(data.Pmoy[item]).toFixed(1)); //Smoy

                        prog = (parseFloat(data.EA[item]) - parseFloat(data.precEA[item])) * 100 / parseFloat(data.precEA[item]);
                        //$('.gridTab td').eq(2).html(prog === null ? 0 : prog.toFixed(1)); //EA gridEAProgVal
                        progressVal($('#EAProgVal'), $('#EAProg'), prog, true, false);

                        prog = ($energySmartMeterCost - $precenergySmartMeterCost) * 100 / $precenergySmartMeterCost;
                        progressVal($('#CostProgVal'), $('#CostProg'), prog, true, false);

                        // prog = (parseFloat(data.ER[item]) - parseFloat(data.precER[item])) * 100 / parseFloat(data.precER[item]);
                        // progressVal($('#ERProgVal'), $('#ERProg'), prog, true, false); //ER

                        // prog = (parseFloat(data.Cos[item]) - parseFloat(data.precCos[item])) * 100 / parseFloat(data.precCos[item]);
                        // progressVal($('#CosProgVal'), $('#CosProg'), prog, false, false); //Cosphi

                        prog = (parseFloat(data.Pmax[item]) - parseFloat(data.precPmax[item])) * 100 / parseFloat(data.precPmax[item]);
                        progressVal($('#PmaxProgVal'), $('#PmaxProg'), prog, true, false); //Pmax

                        prog = (parseFloat(data.Pmoy[item]) - parseFloat(data.precPmoy[item])) * 100 / parseFloat(data.precPmoy[item]);
                        progressVal($('#PmoyProgVal'), $('#PmoyProg'), prog, true, false); //Pmoy
                    }

                });

                /*tabFuelId.forEach(function (item, index) {


                    //MAJ du tableau récaputilatif des modules FUEL
                    $('.fuelTabReport td').eq(index * 4 + 1).html(data.EA[item] === null ? 0 : parseFloat(data.EA[item]).toFixed(1)); //EA
                    // $('.fuelTabReport td').eq(index * 4 + 2).html(data.ER[item] === null ? 0 : parseFloat(data.ER[item]).toFixed(1)); //ER
                    // $('.fuelTabReport td').eq(index * 4 + 3).html(data.Cos[item] === null ? 0 : parseFloat(data.Cos[item]).toFixed(3)); //Cosphi

                    //MAJ du tableau détaillé des modules FUEL
                    if (item === parseInt(strFuelModId)) {
                        $('.fuelTab td').eq(1).html(data.EA[item] === null ? 0 : parseFloat(data.EA[item]).toFixed(1)); //EA
                        $('.fuelTab td').eq(4).html($fuelModCost === null ? 0 : $fuelModCost.toFixed(1)); //ER
                        $('.fuelTab td').eq(7).html(data.Liters[item] === null ? 0 : parseFloat(data.Liters[item]).toFixed(1)); //Cosphi
                        $('.fuelTab td').eq(10).html(data.WorkingTime[item] === null ? 0 : data.WorkingTime[item]); //Temps de fonctionnement
                        $('.fuelTab td').eq(13).html(data.Cos[item] === null ? 0 : parseFloat(data.Cos[item]).toFixed(3)); //Cosphi
                        //$('.fuelTab td').eq(16).html(data.Stock[item] === null ? 0 : data.Stock[item]); //Stock
                        //console.log(data.workTime);
                        //console.log(data.precworkTime);
                        prog = (parseFloat(data.EA[item]) - parseFloat(data.precEA[item])) * 100 / parseFloat(data.precEA[item]);
                        progressVal($('#fuelEAProgVal'), $('#fuelEAProg'), prog, true, false);

                        //$('.fuelTab td').eq(5).html($fuelModCost === null ? 0 : $fuelModCost); //Cost Progression
                        prog = ($fuelModCost - $precfuelModCost) * 100 / $precfuelModCost;
                        progressVal($('#fuelCostProgVal'), $('#fuelCostProg'), prog, true, false);

                        //console.log(typeof data.Liters[item]);
                        //console.log(data.precLiters[item]);
                        prog = (parseFloat(data.Liters[item]) - parseFloat(data.precLiters[item])) * 100 / parseFloat(data.precLiters[item]);
                        progressVal($('#fuelLitersProgVal'), $('#fuelLitersProg'), prog, true, false); //Liters

                        prog = (parseFloat(data.Cos[item]) - parseFloat(data.precCos[item])) * 100 / parseFloat(data.precCos[item]);
                        progressVal($('#fuelCosProgVal'), $('#fuelCosProg'), prog, false, false); //Cosphi

                        var date = new Date('2020-05-22 ' + data.workTime);
                        var precdate = new Date('2020-05-22 ' + data.precworkTime);
                        var prog = new Date(precdate - date);
                        //prog = (data.WorkingTime[item] - data.precWorkingTime[item]) * 100 / data.precWorkingTime[item];
                        progressVal($('#fuelWorkingTimeProgVal'), $('#fuelWorkingTimeProg'), prog, true, true); //WorkingTime 
                    }

                });*/

            }


        },
        error: function (result) {
            console.log("Error");
            console.log(result);
        }
    });
}

function costComputing(tabEA_grid, Psous, subscription, EA) {
    var $Psous = Psous; //console.log($Psous);
    var $subscription = subscription; //console.log($subscription);
    var $EA = EA;
    var $const = 1.192;
    $modCost = 0.0;
    if ($subscription == 'MT') {
        //$Psous = $smartMod->getSite()->getPsous();                   
        $EAHp = 0;
        $EAP = 0;
        //console.log(item);
        tabEA_grid.forEach(function (item, index) {
            //item.forEach(function (item, index) {
            $strhp1_ = '00:00:00';
            $strhp2_ = '17:45:00';
            $strhp3_ = '23:15:00';
            $strhp4_ = '23:45:00';
            $strp1_ = '18:00:00';
            $strp2_ = '23:00:00';
            var dat = new Date(item.DAT);
            var $dat = new moment(dat);
            $str = $dat.format('YYYY-MM-DD HH:mm:ss').toString();
            //console.log($str);
            $strHp1 = $str + ' ' + $strhp1_;
            $strHp2 = $str + ' ' + $strhp2_;
            $strHp3 = $str + ' ' + $strhp3_;
            $strHp4 = $str + ' ' + $strhp4_;

            $datHp1 = new Date($strHp1);
            $datHp2 = new Date($strHp2);
            $datHp3 = new Date($strHp3);
            $datHp4 = new Date($strHp4);
            if ((item.DAT >= $datHp1 && item.DAT <= $datHp2) || (item.DAT >= $datHp3 && item.DAT <= $datHp4)) {
                $EAHp += parseFloat(item.EA);
            } else {
                $EAP += parseFloat(item.EA);
            }
        });
        $modCost = ($EAHp * 60) + ($EAP * 85) + ($Psous * 3700);
        //});

    }
    else if ($subscription == 'Tertiary') {

        if ($EA <= 110) {
            $modCost = $EA * 84 * $const;
        } else if ($EA > 110 && $EA <= 400) {
            $modCost = $EA * 92 * $const;
        } else if ($EA > 400) {
            $modCost = $EA * 99 * $const;
        }
    } else if ($subscription == 'Residential') {
        if ($EA <= 110) {
            $modCost = $EA * 50 * $const;
        } else if ($EA > 110 && $EA <= 400) {
            $modCost = $EA * 79 * $const;
        } else if ($EA > 400 && $EA <= 800) {
            $modCost = $EA * 94 * $const;
        } else if ($EA > 800) {
            $modCost = $EA * 99 * $const;
        }
    }

    return $modCost;
}