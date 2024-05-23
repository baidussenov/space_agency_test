<template>
    <Popup ref='popup' />
    <h1>Комментарии</h1>
    <p class='instruction'>Чтобы удалить комментарий, нажмите на него.</p>
    <div v-for='comment in comments' @click='deleteComment(comment.id)' class='comment'>
        <p class='heading' @click.stop>
            <img src='@/assets/icons/delete.svg' class='delete-icon' alt='delete'>
            <span class='username'>{{ comment.username }}:</span>
        </p>
        <p class='content'>{{ comment.content }}</p>
    </div>
</template>

<script>
import api from '@/api'
import Popup from '@/components/Popup.vue'

export default {
    props: {
        comments: Array
    },
    components: {
        Popup
    },
    methods: {
        async deleteComment(id) {
            try {
                const response = await api.delete(`/api/comment/${id}`)
                const { success, error } = response.data
                if (!success)
                    throw error

                window.location.reload()
            } catch (err) {
                console.error('Ошибка при удалении комментария:', err)
                this.$refs.popup.openPopup(false, 'Произошла ошибка')
            }
        }
    }
}
</script>

<style scoped>
h1 {
    margin-top: 15px;
}

.instruction {
    margin-bottom: 15px;
}

.comment {
    display: flex;
    flex-direction: row;
    font-size: 1.1rem;
    margin: 30px 0;
}

.comment:hover {
    text-decoration: underline;
    cursor: pointer;
}

.heading {
    flex: 1;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    justify-content: flex-end;
    text-align: right;
    margin-right: 20px;
}

.delete-icon {
    display: none;
    height: 1.2rem;
    margin-right: 10px;
    margin-top: 0.2rem;
}

.comment:hover img {
    display: block;
}

.username {
    font-weight: bold;
}

.content {
    flex: 2;
    text-align: left;
}

@media (max-width: 1199px) {
    img {
        display: block;
    }
}

@media (max-width: 767px) {
    .comment {
        flex-direction: column;
    }

    .heading {
        justify-content: flex-start;
    }
}
</style>