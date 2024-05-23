<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <header>
    <i>
      <h1>Тестовое задание для Space Agency</h1>
    </i>
    <nav>
      <RouterLink to='/'>Посты</RouterLink>
      <RouterLink to='/create'>Опубликовать пост</RouterLink>
    </nav>
  </header>
  <main>
    <RouterView />
  </main>
</template>

<style scoped>
nav {
  width: 100%;
  padding: 20px 0;
  display: flex;
  flex-direction: row;
  justify-content: center;
}

nav>a {
  display: block;
  text-decoration: none;
  margin: 0 15px;
  text-transform: uppercase;
  transition: 250ms;
  color: #4287f5;
}

nav>a:after {
  display: block;
  content: '';
  border-bottom: solid 1px #4287f5;
  transform: scaleX(0);
  transition: transform 250ms ease-in-out;
}

nav>a:hover:after {
  transform: scaleX(1);
}
</style>
