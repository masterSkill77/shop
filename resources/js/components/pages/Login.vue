<template>
  <form @submit.prevent="login" method="post">
    <div class="container w-50">
      <label for="name"><b>Utilisateur</b></label>
      <input
        type="text"
        placeholder="Enter Username"
        v-model="email"
        required
      />

      <label for="password"><b>Mot de passe</b></label>
      <input
        type="password"
        placeholder="Enter Password"
        v-model="password"
        required
      />

      <button type="submit">Se connecter</button>
    </div>
  </form>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      password: "",
      email: "",
      apiUrl: "/api/",
    };
  },
  methods: {
    async login() {
      axios
        .post(this.apiUrl + "login", {
          password: this.password,
          email: this.email,
        })
        .then(({ data }) => {
          localStorage.setItem("shop_token", JSON.stringify(data));
          this.$emit("connected", data);
          this.$router.back(0);
        })
        .catch(() => {
          alert("Credentials error");
        });
    },
  },
};
</script>

<style scoped>
/* Bordered form */
form {
  border: 3px solid #f1f1f1;
}

/* Full-width inputs */
input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #04aa6d;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
  opacity: 0.8;
}

/* Extra style for the cancel button (red) */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the avatar image inside this container */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

/* Avatar image */
img.avatar {
  width: 40%;
  border-radius: 50%;
}

/* Add padding to containers */
.container {
  padding: 16px;
}

/* The "Forgot password" text */
span.password {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.password {
    display: block;
    float: none;
  }
  .cancelbtn {
    width: 100%;
  }
}
</style>
