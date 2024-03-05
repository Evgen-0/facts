<script setup>
import {Link, router, useForm} from "@inertiajs/vue3";
import Card from "primevue/card";
import Avatar from "primevue/avatar";
import Button from "primevue/button";
import LikeIcon from "@/Components/LikeIcon.vue";
import SaveIcon from "@/Components/SaveIcon.vue";
import CommentIcon from "@/Components/CommentIcon.vue";
import DislikeIcon from "@/Components/DislikeIcon.vue";

let props = defineProps({
  fact: {
    type: Object,
    required: true
  }
});

const form = useForm({
  favorite: false
});

function countLikes() {
  // Порахувати кількість лайків, якщо true то +1, якщо false то -1
  return props.fact.likes.map(like => like.is_like ? 1 : -1).reduce((a, b) => a + b, 0);
}

const isFavorite = () => {
  return props.fact.user_favorites.length > 0;
};

function favorite() {
  router.post(route("fact.favorite", props.fact.id), {
    onSuccess: () => {
      props.fact.favorite = !props.fact.favorite;
    }
  }, {
    preserveScroll: true
  });
}

function like() {
  router.post(route("fact.like", props.fact.id), {
    onSuccess: () => {
      props.fact.likes.push({id: 1});
    }
  }, {
    preserveScroll: true
  });
}

function dislike() {
  router.post(route("fact.dislike", props.fact.id), {
    onSuccess: () => {
      props.fact.likes.pop();
    }
  }, {
    preserveScroll: true
  });
}
</script>


<template>
  <card class="dark:text-white dark:bg-gray-800 p-2">
    <template #header>
      <div class="flex items-center gap-2 m-2">
        <avatar
          v-if="!!!fact.user.photo"
          :label="fact.user.name.slice(0, 1).toUpperCase()"
          shape="circle"
          style="background-color:#2196F3; color: #ffffff; display: flex; justify-content: center; align-items: center; user-select: none;"
        />
        <avatar
          v-else
          :image="fact.user.photo"
          shape="circle"
          size="normal"
          class="object-cover"
        />
        <div class="transition ease-in hover:text-blue-500 cursor-pointer">
          <Link :href="route('users.show', fact.user.id)">
            {{ fact.user.name }}
          </Link>
        </div>
      </div>
    </template>
    <template #title>
      <Link
        :href="route('facts.show', fact.slug)"
        class="text-lg hover:text-blue-500"
      >
        {{ fact.heading }}
      </Link>
    </template>
    <template #content>
      <div>
        <Link :href="route('facts.show', fact.slug)">
          <img
            class="w-full h-9/12 rounded-lg"
            :src="fact.body"
            :alt="fact.heading"
          >
        </Link>
      </div>
    </template>
    <template #footer>
      <div class="px-2 pt-3 pb-1 flex gap-x-4 justify-between">
        <div class="flex gap-x-3">
          <div class="flex p-2 gap-x-2">
            <form
              method="post"
              @submit.prevent="like"
            >
              <button type="submit">
                <like-icon class="hover:fill-white hover:transition hover:ease-in-out hover:delay-500" />
              </button>
            </form>
            <p>{{ countLikes() }}</p>
            <form
              method="post"
              @submit.prevent="dislike"
            >
              <button type="submit">
                <dislike-icon class="hover:fill-white hover:transition hover:ease-in-out hover:delay-500" />
              </button>
            </form>
          </div>
          <div class="p-2">
            <Link
              :href="route('facts.show', fact.slug)"
              class="flex gap-x-1 select-none"
            >
              <comment-icon />
              Comment
            </Link>
          </div>
        </div>
        <form
          method="post"
          class="flex gap-x-1 p-2 select-none"
          preserve
          @submit.prevent="favorite"
        >
          <Button type="submit">
            <save-icon
              class="hover:transition hover:ease-in-out hover:delay-500"
              :class="isFavorite() ? 'fill-white hover:fill-none' : 'fill-none hover:fill-white'"
            />
          </Button>
        </form>
      </div>
    </template>
  </card>
</template>
