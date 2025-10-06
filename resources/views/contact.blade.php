<x-layout>
  <x-slot:title>Contact Us</x-slot:title>

  <x-alert-success />
  <x-alert-error />

  <div class="py-12 px-4 mx-auto max-w-screen-xl lg:px-8">
    <div class="text-center mb-12">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Contact Our Company</h1>
      <p class="text-gray-600 dark:text-gray-400">We’d love to hear from you. Let’s talk!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      <!-- Contact Info -->
      <div class="space-y-6">
        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Our Office</h2>
          <p class="text-gray-600 dark:text-gray-400">Jl. Inovasi No. 123, Jakarta, Indonesia</p>
        </div>

        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Email</h2>
          <p class="text-gray-600 dark:text-gray-400">contact@yourcompany.com</p>
        </div>

        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Phone</h2>
          <p class="text-gray-600 dark:text-gray-400">+62 812 3456 7890</p>
        </div>

        <div>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Follow Us</h2>
          <div class="flex space-x-4 mt-2">
            <a href="#" class="text-blue-600 hover:text-blue-800">Facebook</a>
            <a href="#" class="text-sky-500 hover:text-sky-700">Twitter</a>
            <a href="#" class="text-pink-500 hover:text-pink-700">Instagram</a>
            <a href="#" class="text-gray-700 hover:text-black">LinkedIn</a>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div>
        <form action="{{ route('contact.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
          @csrf
          <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Your Name</label>
            <input type="text" name="name" required
              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Email Address</label>
            <input type="email" name="email" required
              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Message</label>
            <textarea name="message" rows="5" required
              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
          </div>
          <button type="submit"
            class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">Send Message</button>
        </form>
      </div>
    </div>

    <!-- Google Maps -->
    <div class="mt-16">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 text-center">Find Us on the Map</h2>
      <div class="w-full h-96">
        <iframe
          class="w-full h-full rounded-lg shadow-md"
          frameborder="0"
          style="border:0"
          loading="lazy"
          allowfullscreen
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.677508228571!2d106.82715321531816!3d-6.175392095530458!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3eeced218f3%3A0x301e8f1fc28b2d0!2sMonas%20(Monumen%20Nasional)!5e0!3m2!1sen!2sid!4v1625548888463!5m2!1sen!2sid">
        </iframe>
      </div>
    </div>
  </div>
</x-layout>
