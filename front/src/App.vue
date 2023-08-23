<template>
  <div class="wrapper">
    <div
      class="message"
      v-if="isMessageVisible"
      :class="!!message.red && 'message_red'"
    >
      {{ message.value }}
    </div>
    <div class="image">
      <img class="img" src="../public/img.jpg" alt="image" />
      <div class="input_comment">
        <div class="title_input">
          <div :class="red.input ? 'red' : 'gray'" class="wrapper_input">
            <label for="name" class="label">Имя:</label>
            <input
              maxlength="254"
              @input="change"
              v-model="name"
              type="text"
              id="name"
              placeholder="Введите имя..."
              class="label"
            />
          </div>
          <div :class="red.captcha ? 'red' : 'gray'" class="wrapper_input">
            <label for="captcha" class="label">
              {{ captcha.a }}+{{ captcha.b }}=
            </label>
            <input
              @input="change"
              v-model="captcha.value"
              type="number"
              id="captcha"
              placeholder="Введите ответ..."
              class="label"
            />
          </div>
        </div>
        <div class="wrapper_textarea" :class="red.textarea ? ' red' : ' gray'">
          <label for="textar" class="label">Комментарий</label>
          <textarea
            @input="change"
            v-model="comment"
            rows="3"
            id="textar"
            placeholder="Введите комментарий..."
            class="label"
          />
        </div>
        <button class="send" @click="this.createComment">Отправить</button>
      </div>
      <span class="title_comment">Комментарии:</span>
      <div class="comments">
        <span class="no" v-if="error">Oшибка</span>
        <span class="no" v-else-if="loading">Загрузка...</span>
        <span class="no" v-else-if="comments.length === 0"
          >Нет комментариев!</span
        >
        <comment
          v-else
          v-for="elem in comments"
          :key="elem.id"
          :comment="elem"
          @deleteComment="deleteComment"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Comment from "./components/Comment.vue";
import { getAll, deleteComment, createComment } from "./API";
export default {
  name: "App",
  components: {
    Comment,
  },
  data() {
    return {
      comments: [],
      name: "",
      isMessageVisible: false,
      comment: "",
      captcha: {
        a: "",
        b: "",
        value: "",
      },
      message: { value: "", red: false },
      error: false,
      loading: false,
      red: { input: false, textarea: false, captcha: false },
    };
  },
  methods: {
    showMessage(message, red = false) {
      this.message.red = red;
      this.message.value = message;
      this.isMessageVisible = true;

      setTimeout(() => {
        this.message.red = false;
        this.isMessageVisible = false;
        this.message.value = "";
      }, 3000);
    },
    genereteCaptcha() {
      this.captcha = {
        ...this.captcha,
        a: Math.floor(Math.random() * 10).toString(),
        b: Math.floor(Math.random() * 10).toString(),
      };
    },
    change() {
      if (this.name) {
        this.red.input = false;
      }
      if (this.comment) {
        this.red.textarea = false;
      }
      if (this.captcha.value) {
        this.red.captcha = false;
      }
    },
    createComment() {
      if (
        this.name &&
        this.comment &&
        Number(this.captcha.a) + Number(this.captcha.b) ===
          Number(this.captcha.value)
      ) {
        this.genereteCaptcha();
        this.captcha.value = "";
        this.loading = true;
        createComment({ name: this.name, comment: this.comment })
          .then((e) => {
            if (e.data === "Not create.") return Promise.reject(new Error());
            this.showMessage("Успешно отправлено!");
            this.name = "";
            this.comment = "";
            this.error = false;
            this.getAll();
          })
          .catch(() => {
            this.loading = false;
            this.showMessage("Ошибка отправки!", true);
          });
      } else if (!this.name) {
        this.showMessage("Введите имя!", true);
        this.red.input = true;
      } else if (!this.comment) {
        this.showMessage("Введите комментарий!", true);
        this.red.textarea = true;
      } else if (
        Number(this.captcha.a) + Number(this.captcha.b) !==
        Number(this.captcha.value)
      ) {
        this.showMessage("Решите капчу!", true);
        this.red.captcha = true;
      } 
    },
    deleteComment(id) {
      this.loading = true;
      deleteComment(id)
        .then((e) => {
          if (e.data === "Not deleted.") return Promise.reject(new Error());
          this.showMessage("Успешно удалено!");
          this.getAll();
        })
        .catch(() => {
          this.showMessage("Ошибка удаления!", true);
          this.loading = false;
        });
    },
    getAll() {
      this.loading = true;
      getAll()
        .then((res) => {
          this.comments = res.data || [];
          this.comments.sort(
            (a, b) => new Date(b.created_at) - new Date(a.created_at)
          );
          this.loading = false;
          this.error = false;
        })
        .catch((e) => {
          console.log(e);
          this.comments = [];
          this.loading = false;
          this.error = true;
        });
    },
  },
  created() {
    this.getAll();
    this.genereteCaptcha();
  },
};
</script>

<style>
body {
  background: #e9ecf1;
}
* {
  margin: 0;
  padding: 0;
}
.message {
  top: 0;
  right: 0;
  position: fixed;
  padding: 5px;
  background: green;
  color: white;
  margin: 10px;
  border-radius: 5px;
}
.message_red {
  background: red;
}
.img {
  margin-bottom: 5px;
  width: 100%;
  height: auto;
}
.red {
  border: 1px solid red;
}
#app {
  font-weight: 500;
  font-family: Arial, sans-serif;
  display: flex;
  justify-content: center;
  align-content: flex-start;
  overflow: hidden;
}
.no {
  display: flex;
  justify-content: center;
  font-size: 18px;
  font-weight: 600;
}
.wrapper {
  max-width: 700px;
  margin: 50px 30px;
  width: 100%;
  display: flex;
  background: white;
  border-radius: 8px;
}
.image {
  display: flex;
  flex-direction: column;
  overflow: hidden;
  width: 100%;
  margin: 20px;
}
.input_comment {
  display: flex;
  flex-direction: column;
}
.wrapper_input {
  margin: 5px;
  color: gray;
  width: min-content;
  font-size: 14px;
  font-weight: 600;
  display: flex;
  border-radius: 2px;
  padding: 2px;
}
.wrapper_textarea {
  margin: 5px;
  color: gray;
  font-size: 14px;
  font-weight: 600;
  display: flex;
  flex-direction: column;

  border-radius: 5px;
  padding: 5px;
}
.gray {
  border: 1px solid gray;
}
#textar,
#name,
#captcha {
  outline: none;
  border: none;
}
#textar {
  resize: none;
}
.label {
  padding: 2px;
}
.title_input {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.send {
  background: black;
  color: white;
  font-size: 14px;
  font-weight: 600;
  margin: 5px;
  padding: 4px 6px;
  cursor: pointer;
  border: none;
  border-radius: 3px;
}
.send:hover {
  margin: 4px;
  padding: 5px 7px;
}
.title_comment {
  margin: 5px;
  font-weight: 900;
  font-size: 20px;
}

.comments {
  margin: 5px;
  display: flex;
  flex-direction: column;
}
</style>
