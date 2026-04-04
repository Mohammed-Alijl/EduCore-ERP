/**
 * Dashboard — Enhanced ApexCharts with Animations, Counters & Sparklines
 *
 * Features:
 * - Animated number counters
 * - Stunning chart configurations
 * - Sparkline mini charts for stat cards
 * - 3D tilt effects with Alpine.js
 * - Dark mode auto-detection
 * - Smooth transitions
 */
(function () {
    'use strict';

    const isDarkMode = document.body.classList.contains('dark-theme');

    // ─── Color Palette ────────────────────────────────────────────────────────
    const colors = {
        primary: '#6259ca',
        primaryLight: '#a29bfe',
        success: '#10b759',
        successLight: '#2ee67a',
        info: '#01b8ff',
        infoLight: '#6dd5ed',
        warning: '#f7b731',
        warningLight: '#ffd166',
        danger: '#f15050',
        muted: '#a8afc7',
    };

    // ─── Theme Configuration ──────────────────────────────────────────────────
    const theme = isDarkMode ? {
        background: 'transparent',
        foreColor: '#8d8da8',
        gridColor: '#2e2e50',
        tooltipBg: '#1a1a3e',
        tooltipBorder: '#3d3d6b',
    } : {
        background: 'transparent',
        foreColor: '#7987a1',
        gridColor: '#e8e8f7',
        tooltipBg: '#ffffff',
        tooltipBorder: '#e8e8f7',
    };

    // ══════════════════════════════════════════════════════════════════════════
    // ALPINE.JS - STAT CARD TILT EFFECT
    // ══════════════════════════════════════════════════════════════════════════

    window.statCardTilt = function() {
        return {
            init() {
                this.$el.addEventListener('mousemove', (e) => {
                    const rect = this.$el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const rotateX = (y - centerY) / 10;
                    const rotateY = (centerX - x) / 10;

                    const inner = this.$el.querySelector('.dashboard-stat-card-inner');
                    if (inner) {
                        inner.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
                    }
                });

                this.$el.addEventListener('mouseleave', () => {
                    const inner = this.$el.querySelector('.dashboard-stat-card-inner');
                    if (inner) {
                        inner.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
                    }
                });
            }
        };
    };

    // ══════════════════════════════════════════════════════════════════════════
    // SPARKLINE MINI CHARTS
    // ══════════════════════════════════════════════════════════════════════════

    function initSparklines() {
        // Generate sample 7-day trend data
        const generateTrendData = (base, variance = 0.2) => {
            const data = [];
            for (let i = 0; i < 7; i++) {
                const randomChange = (Math.random() - 0.5) * variance;
                data.push(Math.max(0, base * (1 + randomChange)));
            }
            return data;
        };

        const sparklineConfig = {
            chart: {
                type: 'line',
                height: 30,
                sparkline: { enabled: true },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                },
            },
            stroke: {
                curve: 'smooth',
                width: 2,
            },
            tooltip: {
                enabled: true,
                fixed: {
                    enabled: false
                },
                x: { show: false },
                y: {
                    title: {
                        formatter: () => 'Value: '
                    }
                },
                marker: { show: false }
            },
        };

        // Students Sparkline
        if (document.querySelector('#sparkline-students')) {
            new ApexCharts(document.querySelector('#sparkline-students'), {
                ...sparklineConfig,
                series: [{ data: generateTrendData(100, 0.15) }],
                colors: ['rgba(255, 255, 255, 0.9)'],
            }).render();
        }

        // Teachers Sparkline
        if (document.querySelector('#sparkline-teachers')) {
            new ApexCharts(document.querySelector('#sparkline-teachers'), {
                ...sparklineConfig,
                series: [{ data: generateTrendData(50, 0.1) }],
                colors: ['rgba(255, 255, 255, 0.9)'],
            }).render();
        }

        // Revenue Sparkline
        if (document.querySelector('#sparkline-revenue')) {
            new ApexCharts(document.querySelector('#sparkline-revenue'), {
                ...sparklineConfig,
                series: [{ data: generateTrendData(10000, 0.25) }],
                colors: ['rgba(255, 255, 255, 0.9)'],
            }).render();
        }

        // Attendance Sparkline
        if (document.querySelector('#sparkline-attendance')) {
            new ApexCharts(document.querySelector('#sparkline-attendance'), {
                ...sparklineConfig,
                series: [{ data: generateTrendData(95, 0.05) }],
                colors: ['rgba(255, 255, 255, 0.9)'],
            }).render();
        }
    }

    // ══════════════════════════════════════════════════════════════════════════
    // ANIMATED NUMBER COUNTERS
    // ══════════════════════════════════════════════════════════════════════════

    function animateCounter(element, target, duration = 2000, prefix = '', suffix = '') {
        if (!element) return;

        const start = 0;
        const startTime = performance.now();
        const isDecimal = target % 1 !== 0;

        function easeOutQuart(t) {
            return 1 - Math.pow(1 - t, 4);
        }

        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = easeOutQuart(progress);
            const current = start + (target - start) * easedProgress;

            if (isDecimal) {
                element.textContent = prefix + current.toFixed(1) + suffix;
            } else {
                element.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
            }

            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            }
        }

        requestAnimationFrame(updateCounter);
    }

    // Initialize counters when elements are in viewport
    function initCounters() {
        const statValues = document.querySelectorAll('.dashboard-stat-card .stat-value');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    const text = entry.target.textContent;
                    const hasPercent = text.includes('%');
                    const hasDollar = text.includes('$');

                    let cleanNumber = text.replace(/[^0-9.]/g, '');
                    let number = parseFloat(cleanNumber) || 0;

                    if (hasDollar) {
                        animateCounter(entry.target, number, 2500, '$');
                    } else if (hasPercent) {
                        animateCounter(entry.target, number, 2000, '', '%');
                    } else {
                        animateCounter(entry.target, number, 2000);
                    }
                }
            });
        }, { threshold: 0.3 });

        statValues.forEach(el => observer.observe(el));
    }

    // Initialize quick stats counters
    function initQuickStatsCounters() {
        const quickStats = document.querySelectorAll('.quick-stat-item .stat-number');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    const number = parseInt(entry.target.textContent.replace(/,/g, ''), 10) || 0;
                    animateCounter(entry.target, number, 1500);
                }
            });
        }, { threshold: 0.3 });

        quickStats.forEach(el => observer.observe(el));
    }

    // ══════════════════════════════════════════════════════════════════════════
    // CHART CONFIGURATIONS
    // ══════════════════════════════════════════════════════════════════════════

    const commonOptions = {
        chart: {
            fontFamily: 'inherit',
            toolbar: { show: false },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 1000,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            },
        },
        tooltip: {
            theme: isDarkMode ? 'dark' : 'light',
            style: {
                fontSize: '13px',
            },
            y: {
                formatter: function(value) {
                    return value ? value.toLocaleString() : '0';
                }
            }
        },
    };

    // ─── 1. Enrollment Trend (Area Chart) ────────────────────────────────────

    if (document.querySelector('#chart-enrollment-trend') && typeof enrollmentTrendData !== 'undefined') {
        new ApexCharts(document.querySelector('#chart-enrollment-trend'), {
            ...commonOptions,
            chart: {
                ...commonOptions.chart,
                type: 'area',
                height: 320,
                background: theme.background,
                dropShadow: {
                    enabled: true,
                    top: 10,
                    left: 0,
                    blur: 8,
                    color: colors.primary,
                    opacity: 0.2
                },
            },
            series: [{
                name: dashboardLabels.newStudents || 'New Students',
                data: enrollmentTrendData.data,
            }],
            xaxis: {
                categories: enrollmentTrendData.labels,
                labels: {
                    style: { colors: theme.foreColor, fontSize: '11px', fontWeight: 500 }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    style: { colors: theme.foreColor, fontSize: '11px', fontWeight: 500 },
                    formatter: function(val) {
                        return Math.floor(val);
                    }
                },
            },
            grid: {
                borderColor: theme.gridColor,
                strokeDashArray: 4,
                padding: { left: 10, right: 10 },
            },
            colors: [colors.primary],
            fill: {
                type: 'gradient',
                gradient: {
                    type: 'vertical',
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.05,
                    stops: [0, 100],
                    colorStops: [
                        { offset: 0, color: colors.primary, opacity: 0.4 },
                        { offset: 100, color: colors.primary, opacity: 0.02 }
                    ]
                },
            },
            stroke: {
                curve: 'smooth',
                width: 3,
                lineCap: 'round',
            },
            dataLabels: { enabled: false },
            markers: {
                size: 0,
                hover: {
                    size: 6,
                    sizeOffset: 3
                }
            },
        }).render();
    }

    // ─── 2. Revenue vs Invoices (Mixed Bar/Line) ─────────────────────────────

    if (document.querySelector('#chart-revenue-trend') && typeof revenueTrendData !== 'undefined') {
        new ApexCharts(document.querySelector('#chart-revenue-trend'), {
            ...commonOptions,
            chart: {
                ...commonOptions.chart,
                type: 'bar',
                height: 320,
                background: theme.background,
                stacked: false,
            },
            series: [
                {
                    name: dashboardLabels.collected || 'Collected',
                    type: 'bar',
                    data: revenueTrendData.revenue,
                },
                {
                    name: dashboardLabels.invoiced || 'Invoiced',
                    type: 'line',
                    data: revenueTrendData.invoices,
                },
            ],
            xaxis: {
                categories: revenueTrendData.labels,
                labels: {
                    style: { colors: theme.foreColor, fontSize: '11px', fontWeight: 500 }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    style: { colors: theme.foreColor, fontSize: '11px', fontWeight: 500 },
                    formatter: function (val) {
                        if (val >= 1000000) return '$' + (val / 1000000).toFixed(1) + 'M';
                        if (val >= 1000) return '$' + (val / 1000).toFixed(1) + 'k';
                        return '$' + val;
                    },
                },
            },
            grid: {
                borderColor: theme.gridColor,
                strokeDashArray: 4,
                padding: { left: 10, right: 10 },
            },
            colors: [colors.success, colors.info],
            fill: {
                type: ['solid', 'solid'],
                opacity: [1, 1],
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '55%',
                    dataLabels: { position: 'top' },
                },
            },
            stroke: {
                width: [0, 3],
                curve: 'smooth',
                lineCap: 'round',
            },
            dataLabels: { enabled: false },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                labels: { colors: theme.foreColor },
                markers: { radius: 12 },
                itemMargin: { horizontal: 12 },
            },
            tooltip: {
                ...commonOptions.tooltip,
                y: {
                    formatter: function(value) {
                        return '$' + (value ? value.toLocaleString() : '0');
                    }
                }
            },
        }).render();
    }

    // ─── 3. Attendance Distribution (Donut) ──────────────────────────────────

    if (document.querySelector('#chart-attendance-donut') && typeof attendanceDonutData !== 'undefined') {
        var attendanceTotal = attendanceDonutData.present + attendanceDonutData.absent + attendanceDonutData.late;

        new ApexCharts(document.querySelector('#chart-attendance-donut'), {
            ...commonOptions,
            chart: {
                ...commonOptions.chart,
                type: 'donut',
                height: 320,
                background: theme.background,
            },
            series: attendanceTotal > 0
                ? [attendanceDonutData.present, attendanceDonutData.absent, attendanceDonutData.late]
                : [1],
            labels: attendanceTotal > 0
                ? [
                    dashboardLabels.present || 'Present',
                    dashboardLabels.absent || 'Absent',
                    dashboardLabels.late || 'Late',
                ]
                : [dashboardLabels.noData || 'No Data'],
            colors: attendanceTotal > 0
                ? [colors.success, colors.danger, colors.warning]
                : ['#cccccc'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontWeight: 600,
                                color: theme.foreColor,
                                offsetY: -10,
                            },
                            value: {
                                show: true,
                                fontSize: '28px',
                                fontWeight: 700,
                                color: isDarkMode ? '#e4e4ed' : '#1a1a2e',
                                offsetY: 5,
                                formatter: function (val) {
                                    return parseInt(val, 10).toLocaleString();
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: dashboardLabels.totalRecords || 'Total',
                                fontSize: '13px',
                                fontWeight: 600,
                                color: theme.foreColor,
                                formatter: function (w) {
                                    const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return total.toLocaleString();
                                },
                            },
                        },
                    },
                },
            },
            stroke: {
                width: 3,
                colors: [isDarkMode ? '#1a1a3e' : '#ffffff'],
            },
            dataLabels: { enabled: false },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                labels: { colors: theme.foreColor },
                markers: {
                    width: 12,
                    height: 12,
                    radius: 12,
                },
                itemMargin: { horizontal: 12, vertical: 8 },
            },
        }).render();
    }

    // ─── 4. Students per Grade (Horizontal Bar) ──────────────────────────────

    if (document.querySelector('#chart-students-grade') && typeof studentsPerGradeData !== 'undefined') {
        // Generate gradient colors for each bar
        const gradeColors = [
            colors.primary,
            colors.info,
            colors.success,
            colors.warning,
            colors.primaryLight,
            colors.infoLight,
        ];

        new ApexCharts(document.querySelector('#chart-students-grade'), {
            ...commonOptions,
            chart: {
                ...commonOptions.chart,
                type: 'bar',
                height: 320,
                background: theme.background,
            },
            series: [{
                name: dashboardLabels.students || 'Students',
                data: studentsPerGradeData.data,
            }],
            xaxis: {
                categories: studentsPerGradeData.labels,
                labels: {
                    style: { colors: theme.foreColor, fontSize: '11px', fontWeight: 500 }
                },
            },
            yaxis: {
                labels: {
                    style: { colors: theme.foreColor, fontSize: '11px', fontWeight: 500 },
                    maxWidth: 150,
                },
            },
            grid: {
                borderColor: theme.gridColor,
                strokeDashArray: 4,
                padding: { left: 10, right: 10 },
            },
            colors: [colors.primary],
            fill: {
                type: 'gradient',
                gradient: {
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: [colors.info],
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 6,
                    barHeight: '65%',
                    distributed: false,
                    dataLabels: {
                        position: 'top',
                    },
                },
            },
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                style: {
                    colors: ['#fff'],
                    fontSize: '12px',
                    fontWeight: 600,
                },
                formatter: function(val) {
                    return val > 0 ? val.toLocaleString() : '';
                },
                offsetX: 5,
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 1,
                    color: '#000',
                    opacity: 0.3
                }
            },
        }).render();
    }

    // ══════════════════════════════════════════════════════════════════════════
    // INITIALIZE
    // ══════════════════════════════════════════════════════════════════════════

    // Wait for DOM ready then initialize counters and sparklines
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initCounters();
            initQuickStatsCounters();
            initSparklines();
        });
    } else {
        initCounters();
        initQuickStatsCounters();
        initSparklines();
    }

})();
