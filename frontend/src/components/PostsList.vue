<script setup>
import { ref, onMounted, watch } from 'vue'
import { dateToStr, getThumbnailPath } from '@/utils/helper'
import api from '@/api'

const posts = ref([])
const categories = ref([])
const selectedCategory = ref('0')

const fetchPosts = async () => {
    try {
        const response = await api.get('/api/posts', {
            params: {
                category_id: selectedCategory.value
            }
        })
        const { success, posts: postList, categories: categoryList, error } = response.data
        if (success) {
            posts.value = postList
            categories.value = categoryList
        } else {
            throw error
        }
    } catch (err) {
        console.error('Ошибка при получении постов:', err)
    }
}

onMounted(() => {
    fetchPosts()
})

watch(selectedCategory, fetchPosts)
</script>

<template>
    <div>
        <h3>Выберите категорию:</h3>
        <select v-model="selectedCategory" @change="fetchPosts">
            <option value="0">All Categories</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.title }}
            </option>
        </select>
    </div>
    <div class="grid-wrapper">
        <router-link :to="'/post/' + item.id" class="item" v-for="item in posts" :key="item.id">
            <img :src="getThumbnailPath(item.thumbnail)" alt="thumbnail" class="thumbnail">
            <div class="content">
                <div class="inner-content">
                    <h4>{{ item.title }}</h4>
                    <p class="descr">{{ item.description }}</p>
                    <p class="date">{{ dateToStr(item.created_at) }}</p>
                </div>
                <div class="stats">
                    <div>
                        <img src="@/assets/icons/view.svg" alt="views">
                        <p>{{ item.views }}</p>
                    </div>
                    <div>
                        <p>{{ item.likes }}</p>
                        <img src="@/assets/icons/like.svg" alt="like">
                    </div>
                </div>
            </div>
        </router-link>
    </div>
</template>

<style scoped>
.grid-wrapper {
    display: grid;
    grid-gap: 40px;
    grid-template-columns: repeat(3, 1fr);
}

.item {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
    border-radius: 10px;
    text-decoration: none;
    max-width: 100%;
}

.item:hover {
    cursor: pointer;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.thumbnail {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 5px;
}

.content {
    display: flex;
    flex-direction: column;
    width: 90%;
    height: 100%;
}

.inner-content {
    flex: 1;
}

.item h4 {
    max-width: 100%;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 10px;
    text-transform: uppercase;
    color: #000;
    font-weight: bold;
    margin: 5px 0;
}

.descr {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 10px;
    color: #000;
}

.date {
    position: absolute;
    right: 25px;
    top: 20px;
    color: #CCCCCC;
    font-weight: bold;
}

.stats {
    align-self: flex-end;
}

@media (max-width: 1199px) {
    .grid-wrapper {
        grid-template-columns: repeat(2, 1fr);
    }

    .item>img {
        height: 250px;
    }
}

@media (max-width: 767px) {
    .grid-wrapper {
        grid-template-columns: 1fr;
    }

    .item>img {
        height: 350px;
    }
}
</style>
