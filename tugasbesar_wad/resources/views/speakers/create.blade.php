@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
   
    <main class="flex-1 p-12 bg-[#F8FAFC]">
        <header class="flex justify-between items-center mb-10 max-w-6xl mx-auto">
            <div>
                <h1 class="text-[32px] font-bold text-[#1E293B]">Pembicara</h1>
                <p class="text-[#94A3B8] font-medium mt-1 text-lg leading-none">Pantau atau Ikut Rekrut Kepanitiaan terkini</p>
            </div>
            <div class="flex space-x-5">
                <i class="fas fa-bell text-[#1E293B] text-xl cursor-pointer"></i>
                <i class="fas fa-search text-[#1E293B] text-xl cursor-pointer"></i>
            </div>
        </header>

        <div class="bg-white rounded-[40px] border border-gray-100 shadow-sm p-12 max-w-6xl mx-auto">
            <div class="mb-10">
                <label class="block text-sm font-bold text-[#1E293B] mb-3">Masukkan Nama Pengguna/ID</label>
                <div class="flex space-x-4">
                    <div class="relative flex-1">
                        <input type="text" id="username" 
                            class="w-full pl-6 pr-12 py-4 border border-[#E2E8F0] rounded-2xl outline-none focus:ring-2 focus:ring-[#00BDD6] transition-all text-[#64748B]" 
                            placeholder="dr.sarah.johnson@techuni.edu">
                        <i class="fas fa-search absolute right-6 top-5 text-[#CBD5E1]"></i>
                    </div>
                    <button type="button" onclick="ambilData()" 
                        class="bg-[#4F8AFF] hover:bg-blue-600 text-white px-8 py-4 rounded-2xl flex items-center font-bold text-sm transition shadow-lg shadow-blue-100">
                        <i class="fas fa-download mr-2"></i> Ambil Data
                    </button>
                </div>
            </div>

            <form action="{{ route('speakers.store') }}" method="POST">
                @csrf
                <div class="flex items-center space-x-4 mb-8">
                    <div class="bg-[#00BDD6] p-3 rounded-full text-white w-12 h-12 flex items-center justify-center">
                        <i class="fas fa-user-check text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-[#1E293B] text-lg">Profil Pembicara</h3>
                        <p class="text-xs text-[#94A3B8]">Otomatis Mengambil Informasi</p>
                    </div>
                </div>

                <div class="border border-[#E2E8F0] rounded-[32px] p-10 flex items-center space-x-10 mb-8">
                    <div class="relative">
                        <img id="display_avatar" src="https://ui-avatars.com/api/?name=User" 
                            class="w-32 h-32 rounded-full border-[6px] border-[#00BDD6]/5 object-cover">
                    </div>
                    <div class="flex-1 space-y-3">
                        <input type="text" name="nama_lengkap" id="nama_lengkap" 
                            class="text-2xl font-bold text-[#1E293B] border-none p-0 focus:ring-0 w-full mb-2" placeholder="Dr. Sarah Johnson">
                        
                        <div class="space-y-1 text-[13px]">
                            <p class="text-[#64748B]">Institusi/Perusahaan : <input type="text" name="instansi" id="instansi" class="font-bold text-[#1E293B] border-none p-0 focus:ring-0 w-auto ml-1" placeholder="Technology University"></p>
                            <p class="text-[#64748B]">Bidang Keahlian : <input type="text" name="role_job" id="role_job" class="font-bold text-[#1E293B] border-none p-0 focus:ring-0 w-auto ml-1" placeholder="AI, Machine Learning"></p>
                            <p class="text-[#64748B]">Alamat Email : <input type="text" name="username_platform" id="username_platform" class="font-bold text-[#1E293B] border-none p-0 focus:ring-0 w-auto ml-1" placeholder="dr.sarah@techuni.edu"></p>
                        </div>
                    </div>
                </div>

                <div class="border border-[#E2E8F0] rounded-[32px] p-10 mb-8">
                    <h4 class="font-bold text-[#1E293B] mb-4">Deskripsi Bio</h4>
                    <textarea name="bio_singkat" id="bio_singkat" rows="6" 
                        class="w-full border-none p-0 focus:ring-0 text-[#64748B] text-sm leading-relaxed" 
                        placeholder="Deskripsi bio pembicara akan tampil di sini..."></textarea>
                </div>

                <div class="bg-[#F0FDF4] border border-[#DCFCE7] text-[#166534] p-5 rounded-[24px] flex items-center mb-10">
                    <div class="bg-[#22C55E] p-2 rounded-full text-white mr-4">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Data Profil Berhasil Diambil</p>
                        <p class="text-[11px] text-[#22C55E] font-medium mt-0.5">Last updated: 2 minutes ago</p>
                    </div>
                </div>

                <div class="flex justify-between items-center border-t border-gray-100 pt-8">
                    <p class="text-[12px] text-[#94A3B8] flex items-center">
                        <i class="fas fa-info-circle mr-2 text-sm"></i> Profile information is ready to be saved to the database.
                    </p>
                    <button type="submit" class="bg-[#00B087] hover:bg-[#009673] text-white px-10 py-4 rounded-full font-bold flex items-center shadow-lg shadow-green-100 transition transform active:scale-95">
                        <i class="fas fa-save mr-2"></i> Save to Database
                    </button>
                </div>
                
                <input type="hidden" name="event_id" value="1">
                <input type="hidden" name="avatar_url" id="avatar_url">
            </form>
        </div>
    </main>
</div>
@endsection