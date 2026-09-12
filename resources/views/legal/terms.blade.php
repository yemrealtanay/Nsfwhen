@extends('legal.layout')

@section('title', __('messages.terms_of_service'))
@section('legal_title', __('messages.terms_of_service'))

@section('table_of_contents')
    @if(app()->getLocale() === 'tr')
        <a href="#sec-1" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">1. NSFWhen Nedir</a>
        <a href="#sec-2" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">2. Uygunluk (Yaş Şartı)</a>
        <a href="#sec-3" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">3. Hesaplar</a>
        <a href="#sec-4" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">4. Topluluk Katkıları</a>
        <a href="#sec-5" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">5. Yasaklı Davranışlar</a>
        <a href="#sec-6" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">6. Raporlama ve Yaptırım</a>
        <a href="#sec-7" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">7. Üçüncü Taraf İçeriği (TMDB)</a>
        <a href="#sec-8" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">8. Doğruluk Garantisi Verilmemesi</a>
        <a href="#sec-9" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">9. Garanti Reddi</a>
        <a href="#sec-10" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">10. Sorumluluğun Sınırlandırılması</a>
        <a href="#sec-11" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">11. Tazminat</a>
        <a href="#sec-12" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">12. Telif Hakkı Şikâyetleri</a>
        <a href="#sec-13" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">13. Gizlilik</a>
        <a href="#sec-14" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">14. Koşullardaki Değişiklikler</a>
        <a href="#sec-15" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">15. Fesih</a>
        <a href="#sec-16" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">16. Uygulanacak Hukuk ve Mahkeme</a>
        <a href="#sec-17" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">17. İletişim</a>
    @else
        <a href="#sec-1" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">1. What is NSFWhen</a>
        <a href="#sec-2" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">2. Eligibility (Age Requirement)</a>
        <a href="#sec-3" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">3. Accounts</a>
        <a href="#sec-4" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">4. Community Contributions</a>
        <a href="#sec-5" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">5. Prohibited Conduct</a>
        <a href="#sec-6" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">6. Reporting & Enforcement</a>
        <a href="#sec-7" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">7. Third-Party Content (TMDB)</a>
        <a href="#sec-8" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">8. No Warranty of Accuracy</a>
        <a href="#sec-9" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">9. Disclaimer of Warranties</a>
        <a href="#sec-10" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">10. Limitation of Liability</a>
        <a href="#sec-11" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">11. Indemnification</a>
        <a href="#sec-12" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">12. Copyright Complaints</a>
        <a href="#sec-13" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">13. Privacy</a>
        <a href="#sec-14" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">14. Changes to Terms</a>
        <a href="#sec-15" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">15. Termination</a>
        <a href="#sec-16" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">16. Governing Law & Jurisdiction</a>
        <a href="#sec-17" style="color: var(--text-secondary); text-decoration: none; padding: 2px 0;">17. Contact</a>
    @endif
@endsection

@section('legal_content')

@if(app()->getLocale() === 'tr')
    <!-- TÜRKÇE KULLANIM KOŞULLARI -->
    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; padding: 20px; margin-bottom: 24px;">
        <p style="margin: 0; font-size: 13px; color: #d6dbe0;">
            Bu Kullanım Koşulları ("Koşullar"), <b>nsfwhen.com</b> adresinde faaliyet gösteren NSFWhen ("biz", "Site", "Hizmet") hizmetine erişiminizi ve kullanımınızı düzenler. Hesap oluşturarak, içerik göndererek veya Hizmeti başka bir şekilde kullanarak bu Koşulları kabul etmiş sayılırsınız. Kabul etmiyorsanız Hizmeti kullanmamalısınız.
        </p>
    </div>

    <!-- 1. NSFWhen Nedir -->
    <section id="sec-1" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">1. NSFWhen Nedir</h2>
        <p>NSFWhen, mainstream (pornografik olmayan) filmlerde cinsel içerik veya nudity bulunup bulunmadığını, bulunuyorsa yaklaşık zaman damgasını ve kategorisini kayıt altına alan bir referans indeksidir. Hizmet:</p>
        <ul style="padding-left: 20px; margin-top: 8px; display: flex; flex-direction: column; gap: 6px;">
            <li>İndekslediği içeriğe ait hiçbir pornografik materyali, film klibini, sahne fotoğrafını veya görselini <b>barındırmaz, yayınlamaz ya da bunlara bağlantı vermez.</b></li>
            <li>Yalnızca TMDB lisansı altında sağlanan film metadata'sı ve posterlerini, ayrıca topluluğumuz ve editörlerimizin katkısıyla oluşturulan zaman damgası/kategori verisini gösterir.</li>
            <li>Bir sahne işaretine iliştirilmiş serbest metin açıklama, yorum veya eleştiri toplamaz.</li>
        </ul>
    </section>

    <!-- 2. Uygunluk (Yaş Şartı) -->
    <section id="sec-2" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">2. Uygunluk (Yaş Şartı)</h2>
        <div style="background: #1e1919; border-left: 3px solid #e05a5a; padding: 12px 16px; margin-bottom: 10px; border-radius: 0 3px 3px 0;">
            <b>Yaş Sınırı:</b> Hesap oluşturmak veya içerik göndermek için en az <b>18 yaşında</b> olmanız gerekir.
        </div>
        <p>Hizmeti kullanarak bu şartı taşıdığınızı beyan etmiş olursunuz. Belirli alanlara erişmeden önce yaşınızı onaylamanız istenebilir; bu onay, hukuken tanınan bir yaş doğrulama yöntemi yerine geçmez ve öyle değerlendirilmemelidir.</p>
    </section>

    <!-- 3. Hesaplar -->
    <section id="sec-3" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">3. Hesaplar</h2>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px;">
            <li>Giriş bilgilerinizin gizliliğinden ve hesabınız altında gerçekleşen tüm faaliyetten siz sorumlusunuz.</li>
            <li>Kayıt sırasında doğru ve güncel bilgi vermeniz gerekir.</li>
            <li>Bu Koşulları ihlal eden, yanlış/kötü niyetli içerik gönderen veya hakkında doğrulanmış kötüye kullanım şikâyeti bulunan hesapları askıya alabilir veya kapatabiliriz.</li>
        </ul>
    </section>

    <!-- 4. Topluluk Katkıları -->
    <section id="sec-4" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">4. Topluluk Katkıları</h2>
        <h3 style="font: 600 14px/1.4 var(--font-sans); color: #e6e8eb; margin: 12px 0 6px;">4.1 Neler gönderebilirsiniz</h3>
        <p>Kayıtlı kullanıcılar sahne işaretleri (başlangıç zamanı, bitiş zamanı ve kategori) ve "temiz" onayları (bir filmde böyle bir içerik bulunmadığına dair beyan) gönderebilir. Sahne işaretlerinde serbest metin yorum kabul edilmez.</p>

        <h3 style="font: 600 14px/1.4 var(--font-sans); color: #e6e8eb; margin: 12px 0 6px;">4.2 Doğrulama süreci</h3>
        <p>Gönderiler anında "doğrulanmamış" (topluluk) durumuyla gösterilir. Bir editör, incelemeden sonra gönderiyi "doğrulanmış" veya "reddedilmiş" olarak işaretleyebilir. Doğrulama durumu, sunulan kanıt hakkında editöryal bir değerlendirmeyi yansıtır; doğruluğun garantisi değildir — bkz. Madde 8.</p>

        <h3 style="font: 600 14px/1.4 var(--font-sans); color: #e6e8eb; margin: 12px 0 6px;">4.3 Bize verdiğiniz lisans</h3>
        <p>Bir sahne işareti veya temiz onayı göndererek, bu veriyi kullanma, gösterme, değiştirme, birleştirme ve yeniden dağıtma (kendi API'miz dahil) konusunda NSFWhen'e dünya çapında, telifsiz, süresiz bir lisansı <b style="color: #7cb5ec;">Creative Commons Attribution-ShareAlike (CC BY-SA)</b> lisansı (veya bildirimle benimseyebileceğimiz bir sonraki sürümü) altında vermiş olursunuz. Hizmetin katkı sahibi bilgisini gösterdiği doğrulanmış katkılarınız için adınızın belirtilmesini isteme hakkınız saklıdır.</p>

        <h3 style="font: 600 14px/1.4 var(--font-sans); color: #e6e8eb; margin: 12px 0 6px;">4.4 İtibar puanı ve editörlük statüsü</h3>
        <p>İtibar puanınız, rozetleriniz ve varsa editörlük yetkileriniz, iç moderasyon kriterlerimize göre belirlenir, herhangi bir zamanda değişebilir ve sözleşmesel bir hak teşkil etmez.</p>
    </section>

    <!-- 5. Yasaklı Davranışlar -->
    <section id="sec-5" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">5. Yasaklı Davranışlar</h2>
        <p>Aşağıdakileri yapmamayı kabul edersiniz:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px;">
            <li>Yanlış, yanıltıcı veya kasıtlı olarak hatalı sahne işareti ya da temiz onayı göndermek.</li>
            <li>Cinsel içeriğe dair görsel, video, ses veya açık yazılı tasvir göndermek ya da bunların gönderilmesini talep etmek.</li>
            <li>Rapor sistemini başka kullanıcıları taciz etmek, misilleme yapmak veya kötü niyetle susturmak için kullanmak.</li>
            <li>İtibar, oylama veya doğrulama sistemlerini manipüle etmeye çalışmak (birden fazla hesap veya koordineli oylama dahil).</li>
            <li>TMDB kaynaklı metadata veya posterleri TMDB'nin izin verdiği şartların dışında toplu olarak çekmek veya yeniden yayınlamak.</li>
            <li>Hizmeti, küçüklerin korunmasına ilişkin mevzuat dahil, yürürlükteki hukuku ihlal edecek şekilde kullanmak.</li>
        </ul>
    </section>

    <!-- 6. Raporlama ve Yaptırım -->
    <section id="sec-6" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">6. Raporlama ve Yaptırım</h2>
        <p>Herhangi bir kullanıcı bir sahne işaretini, bir temiz onayını veya başka bir kullanıcıyı raporlayabilir. Raporlar editörler veya yöneticiler tarafından incelenir. Bu Koşulların veya yürürlükteki hukukun ihlal edildiğine makul ölçüde kanaat getirdiğimizde, önceden bildirimde bulunarak ya da bulunmaksızın içeriği kaldırabilir, doğrulama durumunu düşürebilir, itibar puanını askıya alabilir veya hesapları askıya alabilir/kapatabiliriz.</p>
    </section>

    <!-- 7. Üçüncü Taraf İçeriği (TMDB) -->
    <section id="sec-7" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">7. Üçüncü Taraf İçeriği (TMDB)</h2>
        <div style="background: var(--bg-card); border: 1px solid var(--border-medium); border-radius: 3px; padding: 14px 16px; margin-bottom: 10px;">
            Film başlıkları, posterler, oyuncu kadrosu, süre ve ilgili metadata TMDB API'si üzerinden sağlanır. <b>Bu ürün TMDB API'sini kullanmaktadır ancak TMDB tarafından onaylanmamış, sertifikalandırılmamış veya desteklenmemiştir.</b> Bu metadata ve görsellere ilişkin tüm haklar TMDB ve lisans verenlerine aittir. TMDB kaynaklı verinin doğruluğunu, eksiksizliğini veya erişilebilirliğini garanti etmiyoruz.
        </div>
    </section>

    <!-- 8. Doğruluk Konusunda Garanti Verilmemesi -->
    <section id="sec-8" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">8. Doğruluk Konusunda Garanti Verilmemesi</h2>
        <p>Sahne işaretleri ve temiz onayları kullanıcılar tarafından gönderilir ve editörler tarafından makul çaba ilkesiyle incelenir. <b>Herhangi bir sahne işaretinin doğru, eksiksiz veya güncel olduğunu, ya da işareti olmayan bir filmin gerçekten böyle bir içerikten arınmış olduğunu garanti etmiyoruz.</b> Hizmet yalnızca bilgilendirme amaçlıdır ve kendiniz veya sorumluluğunuz altındaki kişiler için içerik maruziyetine ilişkin kararların tek dayanağı olarak kullanılmamalıdır.</p>
    </section>

    <!-- 9. Garanti Reddi -->
    <section id="sec-9" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">9. Garanti Reddi</h2>
        <div style="background: #171a1e; border: 1px solid var(--border-strong); padding: 12px 16px; border-radius: 3px; font-family: var(--font-mono); font-size: 11px; color: #a2b0be; letter-spacing: .02em;">
            HİZMET, YÜRÜRLÜKTEKİ HUKUKUN İZİN VERDİĞİ AZAMİ ÖLÇÜDE, AÇIK VEYA ZIMNİ HİÇBİR GARANTİ VERİLMEKSİZİN "OLDUĞU GİBİ" VE "MEVCUT OLDUĞU ŞEKİLDE" SUNULMAKTADIR.
        </div>
    </section>

    <!-- 10. Sorumluluğun Sınırlandırılması -->
    <section id="sec-10" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">10. Sorumluluğun Sınırlandırılması</h2>
        <div style="background: #171a1e; border: 1px solid var(--border-strong); padding: 12px 16px; border-radius: 3px; font-family: var(--font-mono); font-size: 11px; color: #a2b0be; letter-spacing: .02em;">
            YÜRÜRLÜKTEKİ HUKUKUN İZİN VERDİĞİ AZAMİ ÖLÇÜDE, YUNUS EMRE ALTANAY, HİZMETİN KULLANIMINDAN VEYA KULLANILAMAMASINDAN, HERHANGİ BİR SAHNE İŞARETİNİN DOĞRULUĞUNA DUYULAN GÜVEN DAHİL, DOĞAN DOLAYLI, ARIZİ, ÖZEL VEYA CEZAİ ZARARLARDAN SORUMLU TUTULAMAZ.
        </div>
    </section>

    <!-- 11. Tazminat -->
    <section id="sec-11" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">11. Tazminat</h2>
        <p>İçerik gönderilerinizden, bu Koşulları ihlalinizden veya herhangi bir hukuku ya da üçüncü taraf hakkını ihlalinizden doğan her türlü talebe karşı NSFWhen'i ve yetkililerini, çalışanlarını ve katkıda bulunanlarını tazmin etmeyi ve zarar görmemelerini sağlamayı kabul edersiniz.</p>
    </section>

    <!-- 12. Telif Hakkı Şikâyetleri -->
    <section id="sec-12" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">12. Telif Hakkı Şikâyetleri</h2>
        <p>Sitede telif hakkınızı ihlal eden bir içerik olduğunu düşünüyorsanız, <a href="mailto:y.emrealtanay@gmail.com" style="color: var(--color-blue-link); font-family: var(--font-mono);">y.emrealtanay@gmail.com</a> adresine aşağıdaki bilgileri içeren bir bildirimle başvurun:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 4px; margin-top: 6px;">
            <li>(a) Telif hakkına konu eserin tanımı,</li>
            <li>(b) İhlal iddiasına konu materyal ve sitedeki tam konumu (URL),</li>
            <li>(c) İletişim bilgileriniz (ad, e-posta, telefon),</li>
            <li>(d) Kullanımın telif hakkı sahibi, temsilcisi veya kanun tarafından yetkilendirilmediğine dair iyi niyetli beyanınız.</li>
        </ul>
        <p style="margin-top: 8px;">Başvurunuzu yürürlükteki telif hakkı mevzuatına uygun şekilde ivedilikle inceleyip yanıtlarız.</p>
    </section>

    <!-- 13. Gizlilik -->
    <section id="sec-13" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">13. Gizlilik</h2>
        <p>Kişisel verilerinizin (hesap bilgileri, katkı geçmişi, IP adresi vb.) toplanması ve kullanılması ayrı bir <a href="{{ route('privacy') }}" style="color: var(--color-blue-link); font-weight: 500;">Gizlilik & GDPR Politikası</a>'nda açıklanır.</p>
    </section>

    <!-- 14. Koşullardaki Değişiklikler -->
    <section id="sec-14" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">14. Koşullardaki Değişiklikler</h2>
        <p>Bu Koşulları zaman zaman güncelleyebiliriz. Değişiklik sonrası Hizmeti kullanmaya devam etmeniz, güncellenmiş Koşulları kabul ettiğiniz anlamına gelir. Değişiklik yapıldığında sayfanın başındaki "Son güncelleme" tarihi güncellenir.</p>
    </section>

    <!-- 15. Fesih -->
    <section id="sec-15" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">15. Fesih</h2>
        <p>Hizmeti kullanmayı istediğiniz zaman bırakabilir ve hesabınızın silinmesini talep edebilirsiniz. Bu Koşulların ihlali veya operasyonel/hukuki sebeplerle, makul ölçüde mümkün olduğunda önceden bildirimde bulunarak, erişiminizi askıya alabilir veya sonlandırabiliriz.</p>
    </section>

    <!-- 16. Uygulanacak Hukuk ve Yetkili Mahkeme -->
    <section id="sec-16" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">16. Uygulanacak Hukuk ve Yetkili Mahkeme</h2>
        <p>Bu Koşullardan doğabilecek her türlü uyuşmazlıkta Türkiye Cumhuriyeti (TR) ve Birleşik Krallık (UK) mevzuatı uygulanacak olup, TR ve UK mahkemeleri münhasıran yetkilidir.</p>
    </section>

    <!-- 17. İletişim -->
    <section id="sec-17" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">17. İletişim</h2>
        <p>Bu Koşullarla ilgili tüm sorularınız ve bildirimleriniz için:</p>
        <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px 16px; margin-top: 8px; font-family: var(--font-mono); font-size: 12px;">
            E-posta: <a href="mailto:y.emrealtanay@gmail.com" style="color: var(--color-blue-link);">y.emrealtanay@gmail.com</a><br>
            Yetkili / Temsilci: Yunus Emre Altanay
        </div>
    </section>

@else
    <!-- ENGLISH TERMS OF SERVICE -->
    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; padding: 20px; margin-bottom: 24px;">
        <p style="margin: 0; font-size: 13px; color: #d6dbe0;">
            These Terms of Service ("Terms") govern your access to and use of NSFWhen ("we", "Site", "Service") operating at <b>nsfwhen.com</b>. By creating an account, submitting content, or otherwise using the Service, you agree to be bound by these Terms. If you do not agree, you must not use the Service.
        </p>
    </div>

    <!-- 1. What is NSFWhen -->
    <section id="sec-1" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">1. What is NSFWhen</h2>
        <p>NSFWhen is a reference index recording whether mainstream (non-pornographic) films contain sexual content or nudity, and if so, their approximate timestamps and categories. The Service:</p>
        <ul style="padding-left: 20px; margin-top: 8px; display: flex; flex-direction: column; gap: 6px;">
            <li>Strictly <b>does not host, publish, broadcast, or link to</b> any pornographic material, movie clips, scene screenshots, or explicit images whatsoever.</li>
            <li>Displays exclusively movie metadata and posters supplied under TMDb license, alongside timestamp and category data contributed by our community and editorial team.</li>
            <li>Does not collect or permit free-form text descriptions, commentary, or critiques attached to scene marks.</li>
        </ul>
    </section>

    <!-- 2. Eligibility (Age Requirement) -->
    <section id="sec-2" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">2. Eligibility (Age Requirement)</h2>
        <div style="background: #1e1919; border-left: 3px solid #e05a5a; padding: 12px 16px; margin-bottom: 10px; border-radius: 0 3px 3px 0;">
            <b>Age Restriction:</b> You must be at least <b>18 years of age</b> to register an account or submit content.
        </div>
        <p>By using the Service, you represent and warrant that you meet this requirement. You may be prompted to confirm your age before accessing certain areas; this declaration does not constitute a statutory age verification mechanism and must not be construed as such.</p>
    </section>

    <!-- 3. Accounts -->
    <section id="sec-3" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">3. Accounts</h2>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px;">
            <li>You are responsible for maintaining the confidentiality of your credentials and for all activities that occur under your account.</li>
            <li>You must provide accurate and complete information during registration.</li>
            <li>We reserve the right to suspend or terminate accounts that breach these Terms, submit fraudulent/malicious data, or are subject to substantiated abuse reports.</li>
        </ul>
    </section>

    <!-- 4. Community Contributions -->
    <section id="sec-4" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">4. Community Contributions</h2>
        <h3 style="font: 600 14px/1.4 var(--font-sans); color: #e6e8eb; margin: 12px 0 6px;">4.1 What you can submit</h3>
        <p>Registered users may submit scene marks (start timestamp, end timestamp, and category) and "clean" claims (attestations that a film contains no sexual/nudity scenes). Free-form text commentary is not accepted.</p>

        <h3 style="font: 600 14px/1.4 var(--font-sans); color: #e6e8eb; margin: 12px 0 6px;">4.2 Verification workflow</h3>
        <p>Submissions are displayed immediately with an "unverified" (community) status. An editor may review and mark submissions as "verified" or "rejected". Verification reflects an editorial assessment of submitted evidence; it does not constitute an absolute guarantee of accuracy — see Section 8.</p>

        <h3 style="font: 600 14px/1.4 var(--font-sans); color: #e6e8eb; margin: 12px 0 6px;">4.3 License granted to us</h3>
        <p>By submitting a scene mark or clean vote, you grant NSFWhen a worldwide, royalty-free, perpetual license to use, display, modify, aggregate, and redistribute this data (including via our API) under the <b style="color: #7cb5ec;">Creative Commons Attribution-ShareAlike (CC BY-SA)</b> license (or any subsequent version we may adopt with notice). You retain the right of attribution for verified contributions where attribution is displayed.</p>

        <h3 style="font: 600 14px/1.4 var(--font-sans); color: #e6e8eb; margin: 12px 0 6px;">4.4 Reputation scores and editor status</h3>
        <p>Reputation scores, badges, and editor privileges are determined at our sole editorial discretion, subject to change without notice, and do not constitute a contractual entitlement.</p>
    </section>

    <!-- 5. Prohibited Conduct -->
    <section id="sec-5" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">5. Prohibited Conduct</h2>
        <p>You agree not to:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 6px;">
            <li>Submit false, misleading, or intentionally inaccurate scene marks or clean claims.</li>
            <li>Upload, transmit, or solicit explicit images, video clips, audio recordings, or explicit textual depictions of sexual content.</li>
            <li>Abuse the reporting system to harass, retaliate against, or silence other users.</li>
            <li>Manipulate or tamper with reputation scores, voting mechanisms, or verification queues (including via multi-accounting or coordinated voting).</li>
            <li>Bulk-scrape or re-syndicate TMDb-sourced metadata or posters outside the explicit terms permitted by TMDb.</li>
            <li>Use the Service in violation of applicable laws, including child protection statutes and computer misuse regulations.</li>
        </ul>
    </section>

    <!-- 6. Reporting and Enforcement -->
    <section id="sec-6" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">6. Reporting and Enforcement</h2>
        <p>Any user may submit a report against a scene mark, clean claim, or user account. Reports are reviewed by editors and administrators. If we reasonably determine that a breach of these Terms or applicable law has occurred, we may remove content, downgrade verification status, deduct reputation points, or suspend/terminate accounts with or without prior notice.</p>
    </section>

    <!-- 7. Third-Party Content (TMDb) -->
    <section id="sec-7" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">7. Third-Party Content (TMDb)</h2>
        <div style="background: var(--bg-card); border: 1px solid var(--border-medium); border-radius: 3px; padding: 14px 16px; margin-bottom: 10px;">
            Film titles, posters, cast lists, runtimes, and related metadata are provided via the TMDb API. <b>This product uses the TMDb API but is not endorsed, certified, or otherwise approved by TMDb.</b> All intellectual property rights in and to such metadata and images remain with TMDb and its licensors. We do not warrant the accuracy, completeness, or availability of TMDb-sourced data.
        </div>
    </section>

    <!-- 8. No Warranty of Accuracy -->
    <section id="sec-8" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">8. No Warranty of Accuracy</h2>
        <p>Scene marks and clean claims are crowdsourced and reviewed by editors on a reasonable-effort basis. <b>We do not guarantee that any scene mark is accurate, complete, or up-to-date, nor do we guarantee that an unmarked film is free from sexual content or nudity.</b> The Service is for informational reference only and must not serve as the sole basis for decisions regarding media exposure for yourself or individuals under your care.</p>
    </section>

    <!-- 9. Disclaimer of Warranties -->
    <section id="sec-9" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">9. Disclaimer of Warranties</h2>
        <div style="background: #171a1e; border: 1px solid var(--border-strong); padding: 12px 16px; border-radius: 3px; font-family: var(--font-mono); font-size: 11px; color: #a2b0be; letter-spacing: .02em;">
            TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, THE SERVICE IS PROVIDED "AS IS" AND "AS AVAILABLE", WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED.
        </div>
    </section>

    <!-- 10. Limitation of Liability -->
    <section id="sec-10" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">10. Limitation of Liability</h2>
        <div style="background: #171a1e; border: 1px solid var(--border-strong); padding: 12px 16px; border-radius: 3px; font-family: var(--font-mono); font-size: 11px; color: #a2b0be; letter-spacing: .02em;">
            TO THE MAXIMUM EXTENT PERMITTED BY LAW, YUNUS EMRE ALTANAY SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES ARISING OUT OF OR IN CONNECTION WITH YOUR USE OF OR INABILITY TO USE THE SERVICE, INCLUDING ANY RELIANCE PLACED UPON THE ACCURACY OF SCENE TIMESTAMPS.
        </div>
    </section>

    <!-- 11. Indemnification -->
    <section id="sec-11" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">11. Indemnification</h2>
        <p>You agree to defend, indemnify, and hold harmless NSFWhen, its founder, operators, contributors, and agents from and against any claims, liabilities, damages, and expenses arising out of your content submissions, your violation of these Terms, or your violation of any third-party rights.</p>
    </section>

    <!-- 12. Copyright Complaints -->
    <section id="sec-12" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">12. Copyright Complaints</h2>
        <p>If you believe content on the Site infringes your copyright, please notify <a href="mailto:y.emrealtanay@gmail.com" style="color: var(--color-blue-link); font-family: var(--font-mono);">y.emrealtanay@gmail.com</a> with:</p>
        <ul style="padding-left: 20px; display: flex; flex-direction: column; gap: 4px; margin-top: 6px;">
            <li>(a) Description of the copyrighted work,</li>
            <li>(b) Description and URL of the allegedly infringing material,</li>
            <li>(c) Your contact details (name, email, phone number),</li>
            <li>(d) A statement of good-faith belief that the use is unauthorized.</li>
        </ul>
        <p style="margin-top: 8px;">We will review and respond promptly in compliance with applicable copyright legislation.</p>
    </section>

    <!-- 13. Privacy -->
    <section id="sec-13" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">13. Privacy</h2>
        <p>Collection and use of personal data (account details, contribution history, technical logs) is governed by our separate <a href="{{ route('privacy') }}" style="color: var(--color-blue-link); font-weight: 500;">Privacy & GDPR Policy</a>.</p>
    </section>

    <!-- 14. Changes to Terms -->
    <section id="sec-14" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">14. Changes to Terms</h2>
        <p>We reserve the right to amend these Terms at any time. Continued use of the Service following revisions constitutes acceptance of the modified Terms. When modified, the "Last updated" date above will be updated.</p>
    </section>

    <!-- 15. Termination -->
    <section id="sec-15" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">15. Termination</h2>
        <p>You may discontinue use of the Service and request deletion of your account at any time. We may suspend or terminate your access for violation of these Terms or for operational/legal reasons, with reasonable notice where practicable.</p>
    </section>

    <!-- 16. Governing Law & Jurisdiction -->
    <section id="sec-16" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">16. Governing Law & Jurisdiction</h2>
        <p>These Terms and any disputes arising out of or related to them shall be governed by and construed in accordance with the laws of the Republic of Turkey and the United Kingdom, subject to the jurisdiction of the competent courts of Turkey and the UK.</p>
    </section>

    <!-- 17. Contact -->
    <section id="sec-17" style="margin-bottom: 28px; scroll-margin-top: 30px;">
        <h2 style="font: 600 18px/1.3 var(--font-serif); color: #f2f4f6; margin-bottom: 8px;">17. Contact</h2>
        <p>For inquiries regarding these Terms:</p>
        <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 12px 16px; margin-top: 8px; font-family: var(--font-mono); font-size: 12px;">
            Email: <a href="mailto:y.emrealtanay@gmail.com" style="color: var(--color-blue-link);">y.emrealtanay@gmail.com</a><br>
            Controller / Representative: Yunus Emre Altanay
        </div>
    </section>
@endif

@endsection
