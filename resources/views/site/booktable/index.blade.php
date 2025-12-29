@extends('layouts.site')

@section('content')
@include('site.components.page-header')

<div class="page-book-table">
    <div class="container">
        <div class="row align-items-center">
            {{-- Sol taraf: Görsel --}}
            <div class="col-lg-6">
                <div class="book-table-image">
                    <figure class="image-anime">
                        <img src="{{ asset('assets/images/524x704.webp') }}" alt="Rezervasyon">
                    </figure>
                </div>
            </div>

            {{-- Sağ taraf: Form --}}
            <div class="col-lg-6">
                <div class="book-table-content">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Rezervasyon</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Online Masa Ayırtın</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.2s">Özel günleriniz veya keyifli bir akşam yemeği için yerinizi şimdiden ayırtın.</p>
                    </div>

                    {{-- Başarı Mesajı --}}
                    @if(session('success'))
                        <div class="alert alert-success wow fadeInUp">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Hata Mesajları --}}
                    @if ($errors->any())
                        <div class="alert alert-danger wow fadeInUp">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="contact-us-form wow fadeInUp" data-wow-delay="0.6s">
                        {{-- Form Action Güncellendi --}}
                        <form id="reservationForm" action="{{ route('site.reservation.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 mb-5">
                                    <input type="text" name="fname" class="form-control" placeholder="Adınız" required>
                                </div>
                                
                                <div class="form-group col-md-6 mb-5">
                                    <input type="text" name="lname" class="form-control" placeholder="Soyadınız" required>
                                </div>

                                <div class="form-group col-md-6 mb-5">
                                    <input type="email" name="email" class="form-control" placeholder="E-Posta" required>
                                </div>
                                
                                <div class="form-group col-md-6 mb-5">
                                    <input type="text" name="phone" class="form-control" placeholder="Telefon" required>
                                </div>

                                <div class="form-group col-md-6 mb-5">
                                    <input type="date" name="date" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6 mb-5">
                                    <select name="time" class="form-control form-select" required>
                                        <option value="" disabled selected>Saat Seçiniz</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                    </select>
                                </div>

                                <div class="col-lg-12">
                                    <div class="book-table-btn">
                                        <button type="submit" class="btn-default">Rezervasyon Talebi Gönder</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection