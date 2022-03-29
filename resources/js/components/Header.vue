<template>
  <header>
    <nav>
      <li><router-link :to="{name:'Home'}">Home</router-link></li>
      <li><router-link :to="{name:'About'}">About</router-link></li>
    </nav>
  </header>
</template>

<script>
export default {
    name:'Header',

}
</script>

<style lang="scss" scoped>
.headerSection{
  width: 100%;
  height: 40px;
  padding: 10px;
  background-color: rgba(128, 128, 128, 0.11);
  border-radius: 20px;
}
</style>