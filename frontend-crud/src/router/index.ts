import { useAuthStore } from "@/stores/authStore";
import Course from "@/views/auth/Course.vue";
import CreateCourse from "@/views/auth/CreateCourse.vue";
import Dashboard from "@/views/auth/Dashboard.vue";
import EditCourse from "@/views/auth/EditCourse.vue";
import ForgotPassword from "@/views/auth/ForgotPassword.vue";
import Login from "@/views/auth/Login.vue";
import MailVerification from "@/views/auth/MailVerification.vue";
import NotFound from "@/views/auth/NotFound.vue";
import Register from "@/views/auth/Register.vue";
import ResetPassword from "@/views/auth/ResetPassword.vue";
import TrainerProfile from "@/views/auth/TrainerProfile.vue";
import UserSettings from "@/views/auth/UserSettings.vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/register",
      name: "register",
      component: Register,
    },
    {
      path: "/login",
      name: "login",
      component: Login,
    },
    {
      path: "/",
      name: "dashboard",
      component: Dashboard,
      meta: { requiresAuth: true },
    },
    {
      path: "/settings",
      name: "settings",
      component: UserSettings,
      meta: { requiresAuth: true },
    },
    // {
    //   path: "/userProfile",
    //   name: "userProfile",
    //   component: UserProfile,
    //   meta: { requiresAuth: true },
    // },
    {
      path: "/course/:id",
      name: "course",
      component: Course,
      meta: { requiresAuth: true },
    },
    {
      path: "/trainer-profile/:id",
      name: "trainer-profile",
      component: TrainerProfile,
      meta: { requiresAuth: true },
    },
    {
      path: "/create-course",
      name: "create-course",
      component: CreateCourse,
      meta: { requiresAuth: true },
    },
    {
      path: "/edit-course/:id",
      name: "edit-course",
      component: EditCourse,
      meta: { requiresAuth: true },
    },
    {
      path: "/forgot-password",
      name: "forgot-password",
      component: ForgotPassword,
    },
    {
      path: "/password-reset/:token",
      name: "password-reset",
      component: ResetPassword,
    },
    {
      path: "/verify-mail",
      name: "verify-mail",
      component: MailVerification,
      meta: { requiresAuth: true },
    },
    { path: "/:pathMatch(.*)*", name: "NotFound", component: NotFound },
  ],
});

// Global Navigation Guard
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();
  const authorizedUrl = [
    "/verify-mail",
    "/login",
    "/register",
    "/password-reset",
    "/password-reset/:token",
    "/forgot-password",
  ];
  // Only fetch if required and user not yet authenticated
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    await authStore.fetchUser();
  }

  if (
    !authStore.user?.email_verified_at &&
    !authorizedUrl.includes(to.path) &&
    !to.path.startsWith("/password-reset") &&
    to.name !== "NotFound"
  ) {
    return next("/verify-mail");
  }

  // After fetch attempt, still unauthenticated? Redirect
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    return next("/login");
  }

  return next();
});

export default router;
