<template>
  <section class="first flex flex-col items-center pb-32">
    <div class="flex items-center">
      <img
        src="../../../../public/images/key_manager_logo.svg"
        class="mr-3 h-6 sm:h-9 scale-125"
        alt="logo"
      />
      <p class="text-2xl font-bold py-10 mb-2">Key Manager</p>
    </div>
    <div class="flex items-center max-w-4xl mt-16">
      <div class="w-1/2">
        <h1 class="text-4xl font-semibold my-4">Create a new team</h1>
        <p>
          Key Manager gives your team a home - a place where they manage virtual
          keys together. To create a new workspace, click the button below.
        </p>
        <button
          class="
            image
            bg-gradient-to-r
            from-blue-500
            to-sky-400
            p-2
            px-4
            my-3
            font-bold
            rounded
            text-white
            flex
            items-center
          "
        >
          Create a Team
        </button>
      </div>
      <div class="w-1/2">
        <img
          src="../../../../public/images/qrcodebusiness.jpg"
          alt="QR Code business"
        />
      </div>
    </div>
  </section>
  <div class="flex justify-center">
    <div class="circle">OR</div>
  </div>
  <section class="second flex flex-col items-center pb-32">
    <div class="w-128">
      <p class="font-semibold my-5">Accept an invitation</p>
      <div class="w-full h-96 border border-gray-200 shadow-lg rounded"></div>
    </div>
  </section>
</template>

<style scoped>
* {
  font-family: "montserrat";
}

.first {
  background-color: #f7f7f7;
}

.circle {
  background-color: white;
  border-radius: 100%;
  padding: 20px;
  font-weight: 500;
  position: relative;
  bottom: 31px;
}
</style>
