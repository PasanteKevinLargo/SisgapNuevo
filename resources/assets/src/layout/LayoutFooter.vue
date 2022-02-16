<template>
  <nav class="layout-footer footer" :class="getLayoutFooterBg()">
    <div class="container-fluid container-p-x pb-3">
      <a href="http://www.main-data.net/megued/" class="footer-link pt-3"  target="_blank">CIESAL</a>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'app-layout-footer',

  methods: {
    getLayoutFooterBg () {
      return `bg-${this.layoutFooterBg}`
    }
  }
}
</script>
