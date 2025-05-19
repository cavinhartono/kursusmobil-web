<div id="<?= $chartId ?>"></div>
<script>
  fetch("<?= $dataUrl ?>")
    .then(res => res.json())
    .then(data => {
      const options = {
        chart: {
          type: 'bar'
        },
        series: [{
          name: 'Total',
          data: data.series
        }],
        xaxis: {
          categories: data.labels
        },
        title: {
          text: "<?= $title ?>",
          align: 'center'
        },
        colors: ['#00BFFF']
      };
      const chart = new ApexCharts(document.querySelector("#<?= $chartId ?>"), options);
      chart.render();
    });
</script>