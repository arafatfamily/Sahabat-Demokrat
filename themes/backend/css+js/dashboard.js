jQuery(function($) {
    'use strict';	
    var ULTRA_SETTINGS = window.ULTRA_SETTINGS || {};
    ULTRA_SETTINGS.chartJS = function() {
        var randomScalingFactor = function() {
            return Math.round(Math.random() * 100)
        };
		$.ajax({
			url: "site/statistik",
			type: 'POST',
			dataType: 'json',
			success: function (response) {
				var arAHarian = new Array(); var arIHarian = new Array(); var arLblHarian = new Array();
				if (response.cdHarian.length > 0) {
					for (var i=0;i<response.cdHarian.length;i++) {
						arAHarian.push(response.cdHarian[i].active);
						arIHarian.push(response.cdHarian[i].inactive);
						arLblHarian.push(response.cdHarian[i].label);
					}
				}
				var barChartHarian = {
					labels: arLblHarian,
					datasets: [{
						fillColor: "rgba(102, 189, 120,1.0)",
						strokeColor: "rgba(102, 189, 120,0.8)",
						highlightFill: "rgba(102, 189, 120,0.8)",
						highlightStroke: "rgba(102, 189, 120,1.0)",
						data: arAHarian
					}, {
						fillColor: "rgba(240,80,80,1.0)",
						strokeColor: "rgba(240,80,80,0.8)",
						highlightFill: "rgba(240,80,80,0.8)",
						highlightStroke: "rgba(240,80,80,1.0)",
						data: arIHarian
					}]
				}
				var ctxb = document.getElementById("bar-harian").getContext("2d");
				window.myBar = new Chart(ctxb).Bar(barChartHarian, {
					responsive: true,
					maintainAspectRatio: false,
				});
				var arAMingguan = new Array(); var arIMingguan = new Array(); var arLblMingguan = new Array();
				if (response.cdMingguan.length > 0) {
					for (var i=0;i<response.cdMingguan.length;i++) {
						arAMingguan.push(response.cdMingguan[i].active);
						arIMingguan.push(response.cdMingguan[i].inactive);
						arLblMingguan.push(response.cdMingguan[i].label);
					}
				}
				var barChartMingguan = {
					labels: arLblMingguan,
					datasets: [{
						fillColor: "rgba(31,181,172,1)",
						strokeColor: "rgba(31,181,172,0.8)",
						highlightFill: "rgba(31,181,172,0.8)",
						highlightStroke: "rgba(31,181,172,1)",
						data: arAMingguan
					}, {
						fillColor: "rgba(240,80,80,1.0)",
						strokeColor: "rgba(240,80,80,0.8)",
						highlightFill: "rgba(240,80,80,0.8)",
						highlightStroke: "rgba(240,80,80,1.0)",
						data: arIMingguan
					}]
				}
				var ctxb = document.getElementById("bar-mingguan").getContext("2d");
				window.myBar = new Chart(ctxb).Bar(barChartMingguan, {
					responsive: true,
					maintainAspectRatio: false,
				});
				
				var arBlnActive = new Array(); var arBlnInactive = new Array(); var arLblBulanan = new Array();
				if (response.cdBulanan.length > 0) {
					for (var i=0;i<response.cdBulanan.length;i++) {
						arBlnActive.push(response.cdBulanan[i].active);
						arBlnInactive.push(response.cdBulanan[i].inactive);
						arLblBulanan.push(response.cdBulanan[i].label);
					}
				}
				var barChartBulanan = {
					labels: arLblBulanan,
					datasets: [{
						fillColor: "rgba(35, 183, 229,1.0)",
						strokeColor: "rgba(35, 183, 229,0.8)",
						highlightFill: "rgba(35, 183, 229,0.8)",
						highlightStroke: "rgba(35, 183, 229,1.0)",
						data: arBlnActive
					}, {
						fillColor: "rgba(240,80,80,1.0)",
						strokeColor: "rgba(240,80,80,0.8)",
						highlightFill: "rgba(240,80,80,0.8)",
						highlightStroke: "rgba(240,80,80,1.0)",
						data: arBlnInactive
					}]
				}
				var ctxb = document.getElementById("bar-bulanan").getContext("2d");
				window.myBar = new Chart(ctxb).Bar(barChartBulanan, {
					responsive: true,
					maintainAspectRatio: false,
				});
				var arATahunan = new Array(); var arITahunan = new Array(); var arLblTahunan = new Array();
				if (response.cdTahunan.length > 0) {
					for (var i=0;i<response.cdTahunan.length;i++) {
						arATahunan.push(response.cdTahunan[i].active);
						arITahunan.push(response.cdTahunan[i].inactive);
						arLblTahunan.push(response.cdTahunan[i].label);
					}
				}
				var barChartTahunan = {
					labels: arLblTahunan,
					datasets: [{
						fillColor: "rgba(153, 114, 181,1.0)",
						strokeColor: "rgba(153, 114, 181,0.8)",
						highlightFill: "rgba(153, 114, 181,0.8)",
						highlightStroke: "rgba(153, 114, 181,1.0)",
						data: arATahunan
					}, {
						fillColor: "rgba(240,80,80,1.0)",
						strokeColor: "rgba(240,80,80,0.8)",
						highlightFill: "rgba(240,80,80,0.8)",
						highlightStroke: "rgba(240,80,80,1.0)",
						data: arITahunan
					}]
				}
				var ctxb = document.getElementById("bar-tahunan").getContext("2d");
				window.myBar = new Chart(ctxb).Bar(barChartTahunan, {
					responsive: true,
					maintainAspectRatio: false,
				});
			}
		});
    };
    $(document).ready(function() {});
    $(window).resize(function() {});
    $(window).load(function() {
        ULTRA_SETTINGS.chartJS();
    });
});
