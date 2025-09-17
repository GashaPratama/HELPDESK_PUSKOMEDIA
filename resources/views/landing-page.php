<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Puskomedia Helpdesk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); }
    .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
  </style>
</head>
<body class="bg-slate-50 font-sans text-slate-800">

  <!-- Navbar -->
  <header class="bg-white/80 backdrop-blur-sm border-b border-slate-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-10 h-10 rounded-lg" />
          <h1 class="text-xl font-semibold text-slate-800">Puskomedia Helpdesk</h1>
        </div>
        <nav class="hidden md:flex space-x-8">
          <a href="#features" class="text-slate-600 hover:text-slate-800 transition-colors">Fitur</a>
          <a href="#about" class="text-slate-600 hover:text-slate-800 transition-colors">Tentang</a>
          <a href="#contact" class="text-slate-600 hover:text-slate-800 transition-colors">Kontak</a>
        </nav>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="gradient-bg min-h-screen flex items-center">
    <div class="max-w-7xl mx-auto px-6 py-20">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Text Content -->
        <div class="space-y-8">
          <div class="space-y-4">
            <h2 class="text-5xl lg:text-6xl font-bold text-slate-800 leading-tight">
              Helpdesk
              <span class="text-slate-600">Puskomedia</span>
            </h2>
            <p class="text-xl text-slate-600 leading-relaxed max-w-lg">
              Solusi profesional untuk keluhan dan pertanyaan pelanggan dengan dukungan teknis terbaik.
            </p>
          </div>
          
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="login" class="inline-flex items-center justify-center px-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
              Masuk / Daftar
            </a>
            <a href="#features" class="inline-flex items-center justify-center px-8 py-4 border-2 border-slate-300 hover:border-slate-400 text-slate-700 hover:text-slate-800 font-semibold rounded-lg transition-all duration-300">
              Pelajari Lebih Lanjut
            </a>
          </div>
        </div>

        <!-- Image/Illustration -->
        <div class="relative">
          <div class="bg-white rounded-2xl p-8 card-shadow">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-full max-w-md mx-auto rounded-lg" />
          </div>
          <!-- Decorative elements -->
          <div class="absolute -top-4 -right-4 w-24 h-24 bg-slate-200 rounded-full opacity-20"></div>
          <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-slate-300 rounded-full opacity-10"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <h3 class="text-4xl font-bold text-slate-800 mb-4">Mengapa Memilih Helpdesk Kami?</h3>
        <p class="text-xl text-slate-600 max-w-2xl mx-auto">
          Kami menyediakan layanan dukungan teknis yang profesional dan responsif untuk kebutuhan hosting Anda.
        </p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl card-shadow card-hover border border-slate-100">
          <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <h4 class="text-xl font-semibold text-slate-800 mb-4">Respon Cepat</h4>
          <p class="text-slate-600 leading-relaxed">Kami menjawab keluhan Anda dalam hitungan menit, bukan jam. Prioritas utama kami adalah kepuasan pelanggan.</p>
        </div>
        
        <div class="bg-white p-8 rounded-2xl card-shadow card-hover border border-slate-100">
          <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h4 class="text-xl font-semibold text-slate-800 mb-4">Dukungan Profesional</h4>
          <p class="text-slate-600 leading-relaxed">Ditangani langsung oleh tim teknis berpengalaman dan ramah yang siap membantu menyelesaikan masalah Anda.</p>
        </div>
        
        <div class="bg-white p-8 rounded-2xl card-shadow card-hover border border-slate-100">
          <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h4 class="text-xl font-semibold text-slate-800 mb-4">24/7 Online</h4>
          <p class="text-slate-600 leading-relaxed">Kapan pun Anda butuh bantuan, kami siap membantu tanpa henti. Layanan tersedia setiap saat.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
          <h3 class="text-4xl font-bold text-slate-800 mb-6">Tentang Puskomedia Helpdesk</h3>
          <p class="text-lg text-slate-600 leading-relaxed mb-6">
            Sebagai penyedia layanan hosting terpercaya, kami memahami pentingnya dukungan teknis yang responsif dan profesional. Helpdesk kami dirancang khusus untuk memberikan solusi cepat dan tepat untuk setiap kebutuhan hosting Anda.
          </p>
          <div class="space-y-4">
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-slate-600 rounded-full"></div>
              <span class="text-slate-700">Tim teknis berpengalaman</span>
            </div>
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-slate-600 rounded-full"></div>
              <span class="text-slate-700">Infrastruktur hosting yang handal</span>
            </div>
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-slate-600 rounded-full"></div>
              <span class="text-slate-700">Layanan pelanggan 24/7</span>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-2xl p-8 card-shadow">
          <div class="text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
              <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <h4 class="text-2xl font-bold text-slate-800 mb-4">Siap Membantu</h4>
            <p class="text-slate-600">Tim kami siap memberikan dukungan terbaik untuk semua kebutuhan hosting Anda.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="contact" class="bg-slate-800 text-white">
    <div class="max-w-7xl mx-auto px-6 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="md:col-span-2">
          <div class="flex items-center space-x-3 mb-6">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-10 h-10 rounded-lg" />
            <h5 class="text-2xl font-bold">Puskomedia Helpdesk</h5>
          </div>
          <p class="text-slate-300 leading-relaxed max-w-md">
            Solusi layanan digital, web & hosting terbaik untuk kebutuhan bisnis Anda. Kami berkomitmen memberikan dukungan teknis yang profesional dan responsif.
          </p>
        </div>
        
        <div>
          <h5 class="text-lg font-semibold mb-4">Kontak</h5>
          <div class="space-y-3">
            <p class="text-slate-300 flex items-center space-x-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
              <span>support@puskomedia.co.id</span>
            </p>
            <p class="text-slate-300 flex items-center space-x-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
              <span>+62 813-1234-5678</span>
            </p>
          </div>
        </div>
        
        <div>
          <h5 class="text-lg font-semibold mb-4">Ikuti Kami</h5>
          <div class="flex space-x-4">
            <a href="#" class="w-10 h-10 bg-slate-700 hover:bg-slate-600 rounded-lg flex items-center justify-center transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
              </svg>
            </a>
            <a href="#" class="w-10 h-10 bg-slate-700 hover:bg-slate-600 rounded-lg flex items-center justify-center transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
              </svg>
            </a>
            <a href="#" class="w-10 h-10 bg-slate-700 hover:bg-slate-600 rounded-lg flex items-center justify-center transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
      
      <div class="mt-12 pt-8 border-t border-slate-700 text-center">
        <p class="text-slate-400">&copy; 2025 Puskomedia. All rights reserved.</p>
      </div>
    </div>
  </footer>

</body>
</html>
