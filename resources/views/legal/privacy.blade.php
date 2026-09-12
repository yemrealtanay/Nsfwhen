@extends('legal.layout')

@section('title', __('messages.privacy_policy'))
@section('legal_title', __('messages.privacy_policy'))

@section('table_of_contents')
    @if(app()->getLocale() === 'tr')
        <a href="#priv-1" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">1. Veri Sorumlusu</a>
        <a href="#priv-2" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">2. Toplanan Kişisel Veriler</a>
        <a href="#priv-3" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">3. İşleme Amaçları & Sebepleri</a>
        <a href="#priv-4" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">4. Çerezler & Yerel Depolama</a>
        <a href="#priv-5" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">5. Üçüncü Taraflar & Paylaşım</a>
        <a href="#priv-6" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">6. Açık Lisans (CC BY-SA) & Anonimleştirme</a>
        <a href="#priv-7" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">7. Saklama Süreleri</a>
        <a href="#priv-8" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">8. Veri Sahibi Hakları (GDPR/KVKK)</a>
        <a href="#priv-9" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">9. 18+ Yaş Sınırı & Çocuklar</a>
        <a href="#priv-10" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">10. İletişim ve Başvurular</a>
    @else
        <a href="#priv-1" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">1. Data Controller</a>
        <a href="#priv-2" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">2. Data We Collect</a>
        <a href="#priv-3" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">3. Purposes & Legal Bases</a>
        <a href="#priv-4" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">4. Cookies & Local Storage</a>
        <a href="#priv-5" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">5. Third Parties & Sharing</a>
        <a href="#priv-6" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">6. Open License (CC BY-SA) & Anonymization</a>
        <a href="#priv-7" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">7. Data Retention</a>
        <a href="#priv-8" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">8. Your Rights (GDPR & KVKK)</a>
        <a href="#priv-9" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">9. Age Limit (18+) & Minors</a>
        <a href="#priv-10" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">10. Contact & Data Subject Inquiries</a>
    @endif
@endsection

@section('legal_content')

@if(app()->getLocale() === 'tr')
    <!-- TÜRKÇE GİZLİLİK VE GDPR METNİ -->
    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; padding: 20px; margin-bottom: 24px;">
        <p style="margin: 0; font-size: 13px; color: #d6dbe0;">
            Bu Gizlilik ve Kişisel Verilerin Korunması Politikası ("Politika"), <b>nsfwhen.com</b> ("Site", "Hizmet") üzerinden toplanan kişisel verilerin, Avrupa Birliği Genel Veri Koruma Tüzüğü (<b>GDPR</b>), Birleşik Krallık Veri Koruma Kanunu (<b>UK GDPR</b>) ve 6698 sayılı Kişisel Verilerin Korunması Kanunu (<b>KVKK</b>) uyarınca işlenmesine ilişkin şartları açıklamaktadır.
        </p>
    </div>

    <!-- 1. Veri Sorumlusu -->
    <section id="priv-1" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">1. Veri Sorumlusu</h2>
        <p>GDPR Madde 4(7) ve KVKK Madde 3 uyarınca, kişisel verilerinizin işlenmesinden sorumlu Veri Sorumlusu:</p>
        <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px 16px; margin-top: 8px; font-family: var(--font-mono); font-size: 12px;">
            <b>İsim / Temsilci:</b> Yunus Emre Altanay<br>
            <b>Hizmet Adı:</b> NSFWhen (nsfwhen.com)<br>
            <b>İletişim & Veri Koruma E-Postası:</b> <a href="mailto:y.emrealtanay@gmail.com" style="color: var(--color-blue-link);">y.emrealtanay@gmail.com</a>
        </div>
    </section>

    <!-- 2. Toplanan Kişisel Veriler -->
    <section id="priv-2" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">2. Toplanan Kişisel Veriler</h2>
        <p>NSFWhen yalnızca hizmetin sağlanması için asgari düzeyde gerekli verileri ("veri minimizasyonu") toplar:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
            <li><b>Hesap Bilgileri:</b> Kullanıcı adı (takma ad / handle), e-posta adresi, kriptografik olarak tuzlanmış şifre özeti (bcrypt hash), tercih edilen dil (tr/en) ve film türleri.</li>
            <li><b>Topluluk ve Katkı Verileri:</b> Gönderdiğiniz sahne zaman damgaları (başlangıç/bitiş saniyesi), içerik kategorisi, temiz film bildirimleri, doğrulama oyları, itibar puanınız ve kazanılan rozetler. <i>(Not: Sahne işaretleri serbest metin veya yorum içermez.)</i></li>
            <li><b>Teknik ve Güvenlik Verileri:</b> IP adresi, tarayıcı bilgisi (User Agent), güvenlik günlükleri ve oturum yönetimi için zorunlu oturum çerezleri.</li>
            <li><b>Yaş Beyanı:</b> 18+ yaş onayı yalnızca tarayıcınızın yerel depolama alanında (<code style="font-family: var(--font-mono); font-size: 11px; background: #1a1d22; padding: 2px 4px;">localStorage</code>) tutulur, sunucularımızda profil bilgisi olarak işlenmez.</li>
        </ul>
        <div style="background: #19201a; border-left: 3px solid #5aa469; padding: 10px 14px; margin-top: 12px; border-radius: 0 3px 3px 0; font-size: 12px; color: #a4d2ad;">
            <b>Kesinlikle Toplanmayan Veriler:</b> Sitemizde hiçbir pornografik görsel, video veya ses barındırılmadığı gibi; biyometrik veriler, finansal/ödeme bilgileri veya özel nitelikli kişisel veriler kesinlikle toplanmaz.
        </div>
    </section>

    <!-- 3. İşleme Amaçları & Hukuki Sebepler -->
    <section id="priv-3" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">3. İşleme Amaçları ve Hukuki Sebepleri</h2>
        <p>Kişisel verileriniz aşağıdaki amaçlarla ve hukuki sebeplere dayanılarak işlenir:</p>
        <div style="display: grid; grid-template-columns: 180px 1fr; gap: 10px 16px; margin-top: 10px; font-size: 12px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 14px;">
            <span style="font-weight: 600; color: #e6e8eb;">Sözleşmenin İfası (GDPR m. 6(1)(b))</span>
            <span>Kullanıcı hesabı oluşturma, oturum açma, e-posta doğrulama bağlantısı gönderme ve platform hizmetlerinin sunulması.</span>

            <span style="font-weight: 600; color: #e6e8eb;">Meşru Menfaatler (GDPR m. 6(1)(f))</span>
            <span>Platform güvenliğini sağlama, troll/spam veya koordineli manipülasyonu engelleme, şikâyetlerin moderasyonu, itibar puanlarının hesaplanması.</span>

            <span style="font-weight: 600; color: #e6e8eb;">Hukuki Yükümlülük (GDPR m. 6(1)(c))</span>
            <span>Telif hakkı bildirimlerinin incelenmesi, resmi makamların yasal taleplerine uyum sağlanması.</span>
        </div>
    </section>

    <!-- 4. Çerezler & Yerel Depolama -->
    <section id="priv-4" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">4. Çerezler ve Yerel Depolama</h2>
        <p>NSFWhen, kullanıcı deneyimini takip etmek için reklam veya pazarlama çerezi <b>kullanmaz</b>. Yalnızca aşağıdaki teknik araçlar kullanılır:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
            <li><b>Oturum Çerezi (Session Cookie):</b> Giriş durumunuzu ve güvenliğinizi (CSRF koruması) sağlamak amacıyla geçici olarak oluşturulur.</li>
            <li><b>Yerel Depolama (localStorage):</b> 18+ ilk ziyaret yaş onayınız ve arayüz görünüm tercihiniz (ızgara/liste/kart) yalnızca kendi cihazınızda saklanır.</li>
        </ul>
    </section>

    <!-- 5. Üçüncü Taraflar & Paylaşım -->
    <section id="priv-5" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">5. Üçüncü Taraflar ve Veri Aktarımı</h2>
        <p>Kişisel verileriniz asla üçüncü taraflara satılmaz veya kiralanmaz. Yalnızca altyapı hizmeti sağlayan aşağıdaki güvenilir taraflarla sınırlı veri işlenir:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
            <li><b>The Movie Database (TMDb):</b> Film metadata ve posterleri TMDb API üzerinden sorgulanır. Kullanıcıların kişisel kimlik verileri TMDb'ye aktarılmaz.</li>
            <li><b>Sunucu ve Veritabanı Barındırma (Hostinger):</b> Veritabanımız ve sunucu altyapımız güvenlik standartlarına uygun sunucularda barındırılır.</li>
            <li><b>E-posta Servisi (Hostinger SMTP):</b> Hesap aktivasyon ve şifre sıfırlama maillerinin gönderimi için kullanılır.</li>
            <li><b>Kanuni Zorunluluklar:</b> Yetkili mahkemeler veya kolluk kuvvetleri tarafından usulüne uygun iletilen yasal müzekkereler.</li>
        </ul>
    </section>

    <!-- 6. Açık Lisans (CC BY-SA) & Anonimleştirme -->
    <section id="priv-6" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">6. Açık Lisans (CC BY-SA) ve Anonimleştirme</h2>
        <p>Platforma gönderdiğiniz sahne başlangıç/bitiş dakikaları ve içerik kategorileri, kamusal bir sinema içerik kütüphanesinin parçası olarak <b>Creative Commons Attribution-ShareAlike (CC BY-SA)</b> lisansı altında işlenir. Hesabınızı silmeyi talep ettiğinizde:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 4px; margin-top: 6px;">
            <li>Kişisel kimlik verileriniz (e-posta, şifre, doğrudan profil bilgileri) veritabanımızdan kalıcı olarak silinir.</li>
            <li>Gönderdiğiniz film sahne zaman damgaları, genel film rehberinin bütünlüğünü ve topluluk faydasını korumak adına kimliğinizden arındırılarak ("anonimleştirilerek") indeks üzerinde tutulmaya devam eder.</li>
        </ul>
    </section>

    <!-- 7. Saklama Süreleri -->
    <section id="priv-7" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">7. Veri Saklama Süresi</h2>
        <p>Kişisel verileriniz, hesabınız aktif olduğu sürece sistemlerimizde muhafaza edilir. Hesabınızın kapatılması veya silinmesi durumunda kişisel verileriniz 30 gün içerisinde geri döndürülemez biçimde silinir veya anonimleştirilir. Güvenlik ve hata logları ise en fazla 180 gün sonra otomatik olarak temizlenir.</p>
    </section>

    <!-- 8. Veri Sahibi Hakları (GDPR/KVKK) -->
    <section id="priv-8" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">8. Veri Sahibi Hakları (GDPR & KVKK)</h2>
        <p>İlgili mevzuat uyarınca veri sahibi olarak aşağıdaki haklara sahipsiniz:</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px; margin-top: 10px;">
            <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px;">
                <b style="color: #e6e8eb;">Erişim & Bilgi Alma:</b> Hakkınızda hangi verilerin işlendiğini öğrenme ve bir kopyasını talep etme hakkı (GDPR m. 15 / KVKK m. 11).
            </div>
            <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px;">
                <b style="color: #e6e8eb;">Düzeltme:</b> Hatalı veya eksik kişisel verilerinizin güncellenmesini isteme hakkı (GDPR m. 16).
            </div>
            <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px;">
                <b style="color: #e6e8eb;">Silme ("Unutulma Hakkı"):</b> Kişisel verilerinizin sistemlerimizden silinmesini talep etme hakkı (GDPR m. 17).
            </div>
            <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px;">
                <b style="color: #e6e8eb;">Veri Taşınabilirliği:</b> Verilerinizi yapılandırılmış ve yaygın kullanılan formatta alma hakkı (GDPR m. 20).
            </div>
        </div>
        <p style="margin-top: 10px;">Ayrıca ikamet ettiğiniz ülkedeki yetkili veri koruma denetim makamına (Türkiye'de <b>Kişisel Verileri Koruma Kurumu - KVKK</b>, Birleşik Krallık'ta <b>Information Commissioner's Office - ICO</b> veya ilgili AB otoriteleri) şikâyette bulunma hakkınız saklıdır.</p>
    </section>

    <!-- 9. 18+ Yaş Sınırı & Çocuklar -->
    <section id="priv-9" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">9. 18+ Yaş Sınırı ve Çocukların Gizliliği</h2>
        <p>NSFWhen yalnızca 18 yaş ve üzeri yetişkinlerin kullanımına yöneliktir. 18 yaşın altındaki bireylerden bilerek kişisel veri toplamayız. Bir çocuğun ebeveyn veya vasi izni olmadan veri paylaştığını tespit edersek söz konusu veriyi derhal sileriz.</p>
    </section>

    <!-- 10. İletişim ve Başvurular -->
    <section id="priv-10" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">10. İletişim ve Veri Sahibi Başvuruları</h2>
        <p>Yukarıda belirtilen haklarınızı kullanmak, veri silme talebinde bulunmak veya gizlilikle ilgili sorularınızı iletmek için bize doğrudan e-posta gönderebilirsiniz:</p>
        <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 14px 18px; margin-top: 8px; font-family: var(--font-mono); font-size: 12px;">
            <b>Veri Koruma İletişim:</b> <a href="mailto:y.emrealtanay@gmail.com" style="color: var(--color-blue-link);">y.emrealtanay@gmail.com</a><br>
            <b>Temsilci:</b> Yunus Emre Altanay<br>
            <i>Başvurularınız yasal mevzuat gereğince en geç 30 gün içinde ücretsiz olarak sonuçlandırılacaktır.</i>
        </div>
    </section>

@else
    <!-- ENGLISH PRIVACY & GDPR POLICY -->
    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; padding: 20px; margin-bottom: 24px;">
        <p style="margin: 0; font-size: 13px; color: #d6dbe0;">
            This Privacy and Data Protection Policy ("Policy") explains how personal data is collected, used, and protected through <b>nsfwhen.com</b> ("Site", "Service") in compliance with the European Union General Data Protection Regulation (<b>GDPR</b>), the United Kingdom Data Protection Act 2018 (<b>UK GDPR</b>), and the Turkish Law on the Protection of Personal Data No. 6698 (<b>KVKK</b>).
        </p>
    </div>

    <!-- 1. Data Controller -->
    <section id="priv-1" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">1. Data Controller</h2>
        <p>Pursuant to Article 4(7) of the GDPR and applicable data protection legislation, the Data Controller responsible for your personal data is:</p>
        <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px 16px; margin-top: 8px; font-family: var(--font-mono); font-size: 12px;">
            <b>Name / Representative:</b> Yunus Emre Altanay<br>
            <b>Service:</b> NSFWhen (nsfwhen.com)<br>
            <b>Data Protection Contact Email:</b> <a href="mailto:y.emrealtanay@gmail.com" style="color: var(--color-blue-link);">y.emrealtanay@gmail.com</a>
        </div>
    </section>

    <!-- 2. Data We Collect -->
    <section id="priv-2" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">2. Personal Data We Collect</h2>
        <p>NSFWhen strictly adheres to the principle of data minimization, collecting only information necessary to operate the index:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
            <li><b>Account Information:</b> Username (pseudonym/handle), email address, salted cryptographic password hash (bcrypt), interface locale preference (tr/en), and preferred film genres.</li>
            <li><b>Community & Contribution Data:</b> Timestamp entries (start/end seconds), content categories, clean film claims, community verification votes, reputation scores, and badge milestones. <i>(Note: Scene entries contain zero free-form commentary or narrative.)</i></li>
            <li><b>Technical & Operational Data:</b> IP address, browser/device information (User Agent), access logs, and strictly necessary session cookies.</li>
            <li><b>Age Declaration:</b> The 18+ confirmation is stored strictly on your local device (<code style="font-family: var(--font-mono); font-size: 11px; background: #1a1d22; padding: 2px 4px;">localStorage</code>) and is not ingested into your account profile on our servers.</li>
        </ul>
        <div style="background: #19201a; border-left: 3px solid #5aa469; padding: 10px 14px; margin-top: 12px; border-radius: 0 3px 3px 0; font-size: 12px; color: #a4d2ad;">
            <b>Data We Never Collect:</b> We host no explicit images, clips, or videos. We never collect biometric data, payment information, or special category data.
        </div>
    </section>

    <!-- 3. Purposes & Legal Bases -->
    <section id="priv-3" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">3. Purposes and Legal Grounds</h2>
        <p>Your personal data is processed under the following lawful bases established in GDPR Article 6:</p>
        <div style="display: grid; grid-template-columns: 180px 1fr; gap: 10px 16px; margin-top: 10px; font-size: 12px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 14px;">
            <span style="font-weight: 600; color: #e6e8eb;">Performance of Contract (Art. 6(1)(b))</span>
            <span>Account creation, authentication, dispatch of email verification links, and delivery of core site features.</span>

            <span style="font-weight: 600; color: #e6e8eb;">Legitimate Interests (Art. 6(1)(f))</span>
            <span>Platform integrity, abuse prevention, rate limiting, anti-spam protections, editorial moderation, and community reputation scoring.</span>

            <span style="font-weight: 600; color: #e6e8eb;">Legal Obligation (Art. 6(1)(c))</span>
            <span>Investigating copyright notices and fulfilling statutory disclosure obligations where required by law.</span>
        </div>
    </section>

    <!-- 4. Cookies & Local Storage -->
    <section id="priv-4" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">4. Cookies and Local Storage</h2>
        <p>NSFWhen employs <b>no third-party tracking, profiling, or behavioral advertising cookies</b>. We use only strictly necessary technologies:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
            <li><b>Session Cookie:</b> Encrypted cookie maintaining your authenticated state and CSRF attack prevention.</li>
            <li><b>Browser Local Storage:</b> Client-side storage for the 18+ declaration state and film catalog view settings (grid/rows/cards).</li>
        </ul>
    </section>

    <!-- 5. Third Parties & Sharing -->
    <section id="priv-5" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">5. Third-Party Service Providers</h2>
        <p>Personal data is never monetized or sold. Data is shared only with trusted infrastructure providers supporting operations:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
            <li><b>The Movie Database (TMDb):</b> Film titles and posters are queried via TMDb API. User personal data is never transmitted to TMDb.</li>
            <li><b>Hostinger:</b> Secure cloud servers hosting the encrypted database and application files.</li>
            <li><b>SMTP Service:</b> Secure dispatch of account verification emails.</li>
            <li><b>Legal Authorities:</b> Formal disclosure upon receipt of enforceable judicial warrants.</li>
        </ul>
    </section>

    <!-- 6. Open License (CC BY-SA) & Anonymization -->
    <section id="priv-6" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">6. Open License (CC BY-SA) and Anonymization</h2>
        <p>Scene marks and clean confirmations contributed by users form part of a public reference index published under the <b>Creative Commons Attribution-ShareAlike (CC BY-SA)</b> license. Upon account deletion:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 4px; margin-top: 6px;">
            <li>Direct personal identifiers (email, password hash, personal profile) are permanently expunged.</li>
            <li>Submitted timestamp metrics remain in the film index in strictly anonymized form to preserve public utility and index integrity.</li>
        </ul>
    </section>

    <!-- 7. Data Retention -->
    <section id="priv-7" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">7. Data Retention</h2>
        <p>Account data is retained for the duration of your membership. Upon account deletion or termination, personal identifiers are purged or anonymized within 30 days. Operational log files are cleared on a rolling cycle (maximum 180 days).</p>
    </section>

    <!-- 8. Your Rights (GDPR & KVKK) -->
    <section id="priv-8" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">8. Your Data Protection Rights</h2>
        <p>Under the GDPR, UK GDPR, and KVKK, you possess the following rights:</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px; margin-top: 10px;">
            <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px;">
                <b style="color: #e6e8eb;">Right to Access:</b> Inquire whether we process your data and receive a copy thereof (GDPR Art. 15).
            </div>
            <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px;">
                <b style="color: #e6e8eb;">Right to Rectification:</b> Request correction of inaccurate or incomplete records (GDPR Art. 16).
            </div>
            <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px;">
                <b style="color: #e6e8eb;">Right to Erasure ("To be Forgotten"):</b> Request deletion of personal records (GDPR Art. 17).
            </div>
            <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px;">
                <b style="color: #e6e8eb;">Data Portability:</b> Obtain a structured copy of your contributed records (GDPR Art. 20).
            </div>
        </div>
        <p style="margin-top: 10px;">You also hold the right to lodge a complaint with your competent supervisory authority (such as the <b>Information Commissioner's Office (ICO)</b> in the UK, the <b>KVKK</b> in Turkey, or an EU Data Protection Authority).</p>
    </section>

    <!-- 9. Age Limit (18+) & Minors -->
    <section id="priv-9" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">9. Age Limit (18+) and Minors</h2>
        <p>The Service is intended solely for adults aged 18 and over. We do not knowingly collect or solicit personal information from individuals under 18. If we discover that a minor has registered without verifiable parental authorization, we promptly delete the account.</p>
    </section>

    <!-- 10. Contact & Data Subject Inquiries -->
    <section id="priv-10" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">10. Contact and Data Requests</h2>
        <p>To exercise your statutory rights or submit questions regarding privacy practices:</p>
        <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 14px 18px; margin-top: 8px; font-family: var(--font-mono); font-size: 12px;">
            <b>Data Protection Inquiries:</b> <a href="mailto:y.emrealtanay@gmail.com" style="color: var(--color-blue-link);">y.emrealtanay@gmail.com</a><br>
            <b>Representative:</b> Yunus Emre Altanay<br>
            <i>Requests are processed without fee within 30 days.</i>
        </div>
    </section>
@endif

@endsection
