<template>
  <div>
    <!-- Title -->
    <div class="form-group">
      <label for="input-addon-edit-title-text">主標題</label>
      <textarea id="input-addon-edit-title-text"
        v-model="options.title.text" class="form-control"></textarea>
      <small class="form-text text-muted">這個區塊的標題，不需要的話保持空白即可</small>
    </div>

    <title-options v-if="options.title.text !== ''"
      id="input-addon-edit" v-model="options"></title-options>

    <hr />

    <!-- Image -->
    <div class="form-group">
      <label for="input-addon-edit-image">圖片</label>
      <single-image v-model="options.image"
        id="input-addon-edit-image"></single-image>
    </div>

    <!-- LINK -->
    <div class="form-group">
      <label for="input-addon-edit-link">連結</label>
      <input id="input-addon-edit-link" type="url"
        v-model="options.link" class="form-control" />
    </div>

    <!-- New Window -->
    <div class="form-group" v-if="options.link !== ''">
      <label for="input-addon-edit-link-target">新頁面開啟</label>
      <div>
        <phoenix-switch name="addon-edit-link-target"
          v-model="options.link_target"
          id="input-addon-edit-link-target"
          shape="circle"
          color="success"
          true-value="_blank"
          false-value=""></phoenix-switch>
      </div>
    </div>

    <!-- Alt -->
    <div class="form-group">
      <label for="input-addon-edit-alt">提示文字</label>
      <input id="input-addon-edit-alt" type="text"
        v-model="options.alt" class="form-control" />
      <small class="form-text text-muted">
        圖片失效時的提示文字，也對 SEO 有效果
      </small>
    </div>

    <!-- Radius -->
    <div class="form-group" v-if="prepared">
      <label>
        圓角 Border Radius
      </label>
      <div class="d-flex">
        <vue-slide-bar v-model="options.border_radius" class="flex-grow-1" :max="1200"></vue-slide-bar>
        <input type="text" class="form-control ml-2 mt-2" style="width: 3.5rem;"
          v-model="options.border_radius" />
      </div>
    </div>

    <!-- Align -->
    <div class="form-group">
      <label for="input-addon-edit-align">圖片靠齊</label>
      <div class="mt-2">
        <b-form-radio-group v-model="options.align" class="btn-block"  buttons button-variant="outline-primary">
          <b-form-radio value="">
            頁面預設
          </b-form-radio>
          <b-form-radio value="left">
            左
          </b-form-radio>
          <b-form-radio value="center">
            中
          </b-form-radio>
          <b-form-radio value="right">
            右
          </b-form-radio>
        </b-form-radio-group>
      </div>
    </div>
  </div>
</template>

<script>
import TitleOptions from "../form/title-options";
import RwdGroup from "../form/rwd-group";
import SingleImage from "../form/single-image";
import BoxOffset from "../form/box-offset";

export default {
  name: "addon-image",
  components: { TitleOptions, RwdGroup, SingleImage, BoxOffset },
  mixins: [LunaAddonMixin],
  data() {
    return {
      options: {
        image: '',
        border_radius: '',
        alt: '',
        link: '',
        link_target: ''
      }
    }
  }
}
</script>

<style scoped>

</style>
