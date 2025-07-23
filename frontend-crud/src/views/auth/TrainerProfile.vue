<script setup lang="ts">
import CardTrainer from "@/components/CardTrainer.vue";
import IconSpinner from "@/components/icons/IconSpinner.vue";
import IntroductionTrainer from "@/components/IntroductionTrainer.vue";
import ListCoursesByTrainer from "@/components/ListCoursesByTrainer.vue";
import { useTrainerStore } from "@/stores/trainerStore";
import type { User } from "@/types/user";
import { onMounted } from "vue";
import { useRoute } from "vue-router";

const introduction = {
  title: "Introduction",
  description:
    "Milton Finger (born February 8, 1914), better known as Bill Finger, was an American comic strip, comic book, film, and television writer who co-created the DC Comics superhero character Batman (along with Bob Kane).A young, promising writer and part-time shoe dealer Finger, joined Kane's fledgling studio in 1938. Despite his significant (and often iconic) contributions as an imaginative writer, visionary mythos/world builder, and illustration creator, Finger was frequently reduced to ghostwriter status on a number of comics, including Batman and Green Lantern (Original Version). In 1994, Finger was welcomed into the Jack Kirby Hall of Fame, and in 1999, he was inducted into the Will Eisner Award Hall of Fame. In 1985, the company recognised Finger as one of the awardees in their 50th anniversary edition of Fifty Who Made DC Great. In 2014, Finger was posthumously awarded The Inkpot Award.",
};

const route = useRoute();

// fetch data about the trainer (creator) with courses that he/she has created
const fetchTrainer = async () => {
  trainerStore.fetchTrainerWithCourses(route.params.id as string);
};

/** trainer store
 * this store will contain the data of the trainer and the courses that he/she has created
 */
const trainerStore = useTrainerStore();
onMounted(() => {
  fetchTrainer();
});
</script>
<template>
  <template v-if="trainerStore.isLoadingTrainer">
    <div class="w-full flex-1 flex justify-center items-center">
      <IconSpinner />
    </div>
  </template>
  <template v-if="!trainerStore.isLoadingTrainer">
    <div
      class="w-full flex-1 flex flex-col items-center justify-start p-3 bg-[rgb(21,29,59)]"
    >
      <div
        class="w-full 2xl:w-[150vmin] rounded-md flex flex-col lg:flex-row flex-1"
      >
        <div class="flex-1/3 sm:flex-1/4 p-4 relative">
          <!-- Card of trainer that container name, profession, address -->
          <CardTrainer
            :trainer="trainerStore.trainer as User"
            :followed="trainerStore.isFollowed as boolean"
            :followers_count="trainerStore.followersCount as number"
            :followings_count="trainerStore.followingsCount as number"
          />
        </div>
        <div class="flex-2/3 sm:flex-3/4 flex flex-col p-4 text-white">
          <!-- Introduction about the trainer -->
          <IntroductionTrainer :introduction="introduction" />
          <ListCoursesByTrainer
            :courses-of-trainer="trainerStore.courses"
            :name-trainer="trainerStore.trainer?.name as string"
          />
        </div>
      </div>
    </div>
  </template>
</template>
<style scoped></style>
