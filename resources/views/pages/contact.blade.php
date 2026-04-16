@extends('layouts.app')

@section('title', __('messages.contact.title') . ' - ' . App\Models\Setting::get('site_name', 'LongLeaf'))
@section('meta_description', 'Hubungi ' . App\Models\Setting::get('site_name', 'LongLeaf') . ' untuk pertanyaan, saran, atau bantuan. Tim kami siap membantu Anda.')

@section('content')
<!-- Page Banner -->
<section class="page-banner" style="background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%); color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 16px;">📞 {{ __('messages.contact.title') }}</h1>
        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; font-size: 14px;">
            <a href="/" style="color: rgba(255,255,255,0.8);">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.contact.title') }}</span>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section style="padding: 80px 0; background: #f0fdf4;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px;">
            <!-- Contact Info -->
            <div>
                <span style="display: inline-block; background: #d1fae5; color: #059669; padding: 8px 20px; border-radius: 30px; font-size: 14px; font-weight: 600; margin-bottom: 20px;">📍 {{ __('messages.contact.contact_info') }}</span>
                <h2 style="font-size: 36px; font-weight: 700; color: #064e3b; margin-bottom: 20px;">{{ __('messages.contact.lets_talk') }}</h2>
                <p style="color: #065f46; font-size: 16px; line-height: 1.8; margin-bottom: 40px;">
                    {{ __('messages.contact.desc') }}
                </p>
                
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    <div style="display: flex; gap: 20px;">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: white; flex-shrink: 0;">
                            📍
                        </div>
                        <div>
                            <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 4px;">{{ __('messages.contact.store_address') }}</h4>
                            <p style="color: #065f46; line-height: 1.6;">{!! __('messages.contact.address') !!}</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 20px;">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: white; flex-shrink: 0;">
                            📞
                        </div>
                        <div>
                            <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 4px;">{{ __('messages.contact.phone_whatsapp') }}</h4>
                            <p style="color: #065f46; line-height: 1.6;">+62 812-3456-7890<br>{{ __('messages.contact.hours') }}</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 20px;">
                        <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: white; flex-shrink: 0;">
                            ✉️
                        </div>
                        <div>
                            <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 4px;">{{ __('messages.contact.email') }}</h4>
                            <p style="color: #065f46; line-height: 1.6;">hello@LongLeaf.id<br>support@LongLeaf.id</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Links -->
                <div style="margin-top: 40px;">
                    <h4 style="font-size: 16px; font-weight: 600; color: #064e3b; margin-bottom: 16px;">{{ __('messages.contact.follow_us') }}</h4>
                    <div style="display: flex; gap: 12px;">
                        <a href="#" style="width: 44px; height: 44px; background: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" style="width: 44px; height: 44px; background: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" style="width: 44px; height: 44px; background: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" style="width: 44px; height: 44px; background: #10b981; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; transition: all 0.3s;">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1);">
                <h3 style="font-size: 24px; font-weight: 700; color: #064e3b; margin-bottom: 8px;">{{ __('messages.contact.send_message') }}</h3>
                <p style="color: #065f46; margin-bottom: 30px;">{{ __('messages.contact.form_desc') }}</p>
                
                <form action="/contact/send" method="POST">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #064e3b; margin-bottom: 8px;">{{ __('messages.auth.name') }}</label>
                        <input type="text" name="name" required placeholder="{{ __('messages.auth.name') }}"
                               style="width: 100%; padding: 14px 16px; border: 2px solid #dcfce7; border-radius: 12px; font-size: 15px; transition: all 0.3s; outline: none;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #064e3b; margin-bottom: 8px;">{{ __('messages.header.email') }}</label>
                        <input type="email" name="email" required placeholder="email@example.com"
                               style="width: 100%; padding: 14px 16px; border: 2px solid #dcfce7; border-radius: 12px; font-size: 15px; transition: all 0.3s; outline: none;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #064e3b; margin-bottom: 8px;">{{ __('messages.contact.subject') }}</label>
                        <select name="subject" required
                                style="width: 100%; padding: 14px 16px; border: 2px solid #dcfce7; border-radius: 12px; font-size: 15px; transition: all 0.3s; outline: none; background: white;">
                            <option value="">{{ __('messages.contact.select_subject') }}</option>
                            <option value="question">{{ __('messages.contact.product_question') }}</option>
                            <option value="care">{{ __('messages.contact.care_consultation') }}</option>
                            <option value="order">{{ __('messages.contact.order_status') }}</option>
                            <option value="collab">{{ __('messages.contact.collaboration') }}</option>
                            <option value="other">{{ __('messages.contact.other') }}</option>
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 500; color: #064e3b; margin-bottom: 8px;">{{ __('messages.contact.message') }}</label>
                        <textarea name="message" rows="5" required placeholder="{{ __('messages.contact.message') }}..."
                                  style="width: 100%; padding: 14px 16px; border: 2px solid #dcfce7; border-radius: 12px; font-size: 15px; transition: all 0.3s; outline: none; resize: vertical;"></textarea>
                    </div>
                    
                    <button type="submit" style="width: 100%; padding: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; border-radius: 12px; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s;">
                        {{ __('messages.contact.send_message') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section style="padding: 0 0 80px; background: #f0fdf4;">
    <div class="container">
        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1);">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.7782339749898!3d-6.194742393792414!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6a9e4a5b4b1%3A0x2e69f6a9e4a5b4b1!2sKebon%20Jeruk%2C%20Jakarta%20Barat!5e0!3m2!1sid!2sid!4v1234567890"
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section style="padding: 80px 0; background: white;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 700; color: #064e3b;">{{ __('messages.contact.faq') }}</h2>
            <p style="color: #065f46; margin-top: 16px;">{{ __('messages.contact.faq_sub') }}</p>
        </div>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="border-bottom: 1px solid #dcfce7; padding: 24px 0;">
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ __('messages.contact.faq_shipping') }}</h4>
                <p style="color: #065f46; line-height: 1.7;">{{ __('messages.contact.faq_shipping_ans') }}</p>
            </div>
            
            <div style="border-bottom: 1px solid #dcfce7; padding: 24px 0;">
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ __('messages.contact.faq_guarantee') }}</h4>
                <p style="color: #065f46; line-height: 1.7;">{{ __('messages.contact.faq_guarantee_ans') }}</p>
            </div>
            
            <div style="border-bottom: 1px solid #dcfce7; padding: 24px 0;">
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ __('messages.contact.faq_care') }}</h4>
                <p style="color: #065f46; line-height: 1.7;">{{ __('messages.contact.faq_care_ans') }}</p>
            </div>
            
            <div style="border-bottom: 1px solid #dcfce7; padding: 24px 0;">
                <h4 style="font-size: 18px; font-weight: 600; color: #064e3b; margin-bottom: 12px;">{{ __('messages.contact.faq_cod') }}</h4>
                <p style="color: #065f46; line-height: 1.7;">{{ __('messages.contact.faq_cod_ans') }}</p>
            </div>
        </div>
    </div>
</section>
@endsection
