<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController extends AbstractController
{

    #[Route(path: "/", name: "landing", methods: ['GET'])]
    public function landing(): Response
    {
        return $this->render('home/landing.html.twig', []);
    }

    #[Route(path: "/", methods: ['POST'])]
    public function landingPost(Request $request): Response
    {
        $mailer = new Mailer(Transport::fromDsn($_ENV['SMTP_DNS']));
        $email = (new TemplatedEmail())
            ->from(new Address('jsms@scriptyre.com', 'Outreach Digital'))
            ->to('hello@outreachdigital.ro')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Un nou potențial client!')
            ->htmlTemplate('email/generic.html.twig')
            ->context([
                'name' => 'Vladones',
                'message' => 'Cineva încearcă să te contacteze de pe outreachdigital.ro. '.$request->request->get('entries').' Mai jos găsești detaliile de contact:',
                'additionalInfo' => $request->request->get('firstName').' '.$request->request->get('lastName').', '.$request->request->get('email').', '.$request->request->get('phone').', mesaj: '.$request->request->get('message'),
                'buttonText' => null,
                'buttonLink' => null,
                'sender' => 'Outreach Digital',
            ]);
        $loader = new FilesystemLoader('templates', '../');
        $twigEnv = new Environment($loader);
        $twigBodyRenderer = new BodyRenderer($twigEnv);
        $twigBodyRenderer->render($email);
        $mailer->send($email);

        $mailer = new Mailer(Transport::fromDsn($_ENV['SMTP_DNS']));
        $email = (new TemplatedEmail())
            ->from(new Address('jsms@scriptyre.com', 'Outreach Digital'))
            ->to($request->request->get('email'))
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Mulțumim de vizită!')
            ->htmlTemplate('email/generic.html.twig')
            ->context([
                'name' => $request->request->get('lastName'),
                'message' => 'Îți mulțumim pentru interes, și abia așteptăm să ne cunoaștem mai bine!',
                'additionalInfo' => 'Am primit datele tale cu succes, și te vom contacta în curând!',
                'buttonText' => null,
                'buttonLink' => null,
                'sender' => 'Outreach Digital',
            ]);
        $loader = new FilesystemLoader('templates', '../');
        $twigEnv = new Environment($loader);
        $twigBodyRenderer = new BodyRenderer($twigEnv);
        $twigBodyRenderer->render($email);
        $mailer->send($email);

        return $this->render('home/landing.html.twig', []);
    }

    #[Route(path: "/individuals/{key}", name: "individuals", methods: ['GET'])]
    public function individuals(string $key): Response
    {
        $individuals = [
            'branding_rebranding' => [
                'originalKey' => 'branding_rebranding',
                'title' => 'Branding / Rebranding',
                'body1' => 'Brandingul și rebrandingul sunt procese esențiale pentru construirea și consolidarea identității unei afaceri. Brandul este cartea de vizită a companiei, reprezentând reputația, valorile și promisiunile acesteia. În cazul rebrandingului, acesta poate fi văzut ca o oportunitate de a revigora și de a revitaliza imaginea și mesajul companiei pentru a se adapta schimbărilor din piață sau pentru a reflecta noi direcții strategice.',
                'body2' => 'Este momentul în care se pot lua decizii importante cu privire la logo, culori, sloganuri și mesaje pentru a transmite o imagine proaspătă și actuală publicului țintă. Indiferent dacă sunteți la început de drum sau decideți să vă reinventați, brandingul și rebrandingul sunt instrumente puternice pentru a vă diferenția și a vă conecta mai bine cu clienții.',
                'attributes' => ['Test1', 'Test2'],
                'price' => 'X',
                'unit' => 'RON',
            ],
            'strategie_digitala' => [
                'originalKey' => 'strategie_digitala',
                'title' => 'Strategie Digitala',
                'body1' => 'O strategie digitală este un plan de acțiune bine gândit care utilizează mediul online pentru a atinge obiectivele unei afaceri sau organizații. Aceasta implică definirea clară a publicului țintă, a obiectivelor specifice, a canalelor de marketing digital potrivite și a mesajelor cheie. O strategie digitală eficientă cuprinde planuri detaliate pentru optimizarea site-ului web, gestionarea conținutului, promovarea pe rețelele sociale, publicitatea online și analiza rezultatelor.',
                'body2' => 'Ea asigură coerența în comunicarea cu audiența și permite o adaptare flexibilă în funcție de schimbările din mediul digital. O strategie digitală bine pusă la punct poate ajuta o afacere să crească vizibilitatea online, să atragă și să convertească clienți, și să se adapteze cu succes la evoluțiile tehnologice și schimbările în comportamentul consumatorilor.',
                'attributes' => ['Analiza pietei', 'Stabilirea publicului cheie', 'Analiza demografica', 'Alegerea canalului de marketing', 'Alegerea mesajelor cheie'],
                'price' => '400',
                'unit' => 'RON',
            ],
            'web_design' => [
                'originalKey' => 'web_design',
                'title' => 'Web Design',
                'body1' => 'Web design-ul este arta și știința de a crea site-uri web atractive și funcționale. Acesta nu se referă doar la aspectul estetic al unui site, ci și la modul în care acesta funcționează și oferă o experiență plăcută utilizatorilor. Un web design de calitate ține cont de aspecte precum navigabilitatea, structura informației, viteza de încărcare a paginilor și compatibilitatea cu diferite dispozitive și browsere.',
                'body2' => 'Un design web bine realizat nu numai că atrage atenția vizitatorilor, dar îi ajută să găsească rapid informațiile de care au nevoie și îi încurajează să interacționeze cu site-ul. Este un element esențial în succesul unei prezențe online și poate face diferența între a atrage clienți sau a-i respinge.',
                'attributes' => ['Test1', 'Test2'],
                'price' => 'X',
                'unit' => 'RON',
            ],
            'campanii_ppc' => [
                'originalKey' => 'campanii_ppc',
                'title' => 'Campanii PPC',
                'body1' => 'Campaniile pay-per-click (PPC) sunt o strategie eficientă de marketing digital în care plătiți doar atunci când utilizatorii dau clic pe anunțurile dvs. pe platforme precum Google Ads sau Facebook Ads. Aceste campanii oferă o modalitate rapidă de a atrage trafic calificat către site-ul dvs. și de a genera potențiali clienți.',
                'body2' => 'Cu PPC, aveți control total asupra bugetului și a targetingului, ceea ce vă permite să vă adresați audienței corecte în funcție de interese, demografie și comportament online. Rezultatele sunt măsurabile și ușor de monitorizat, ceea ce vă permite să ajustați și să optimizați constant campaniile pentru a obține cel mai bun ROI (Return on Investment). PPC poate fi o unealtă puternică pentru a stimula vizibilitatea afacerii dvs. online și pentru a atrage clienți imediat.',
                'attributes' => ['Test1', 'Test2'],
                'price' => 'X',
                'unit' => 'RON',
            ],
            'social_media_management' => [
                'originalKey' => 'social_media_management',
                'title' => 'Social Media Management',
                'body1' => 'Social media managementul implică gestionarea și administrarea strategiei de prezență a unei afaceri pe platformele de socializare precum Facebook, Instagram, Twitter și altele. Acest proces cuprinde planificarea, crearea și distribuirea conținutului, monitorizarea activității și interacțiunilor cu audiența, precum și analiza rezultatelor pentru a îmbunătăți continuu strategia.',
                'body2' => 'Un social media manager este responsabil de menținerea unei prezențe constante și autentice pe rețelele sociale, angajându-se cu comunitatea și gestionând campaniile publicitare pentru a atinge obiectivele de marketing ale afacerii. Social media managementul este esențial pentru construirea și menținerea relațiilor cu clienții, consolidarea brandului și creșterea notorietății pe canalele de socializare.',
                'attributes' => ['Test1', 'Test2'],
                'price' => 'X',
                'unit' => 'RON',
            ],
            'optimizare_seo' => [
                'originalKey' => 'optimizare_seo',
                'title' => 'Optimizare SEO',
                'body1' => 'Optimizarea pentru motoarele de căutare (SEO) este un proces esențial în marketingul digital, concentrat pe îmbunătățirea vizibilității unui site web în rezultatele căutărilor organice. Prin strategii precum optimizarea cuvintelor cheie, crearea de conținut de calitate, îmbunătățirea structurii site-ului și obținerea de backlink-uri de la surse relevante, SEO poate ajuta un site să apară în primele poziții ale motorului de căutare, câștigând astfel mai mult trafic organic și mai multe oportunități de afaceri.',
                'body2' => 'Optimizarea SEO nu este doar despre obținerea unor poziții mai bune în căutări, ci și despre oferirea unei experiențe mai bune utilizatorilor și înțelegerea nevoilor lor pentru a furniza conținut și informații relevante. Este o investiție valoroasă în creșterea online a unei afaceri și în construirea unei prezențe solide pe internet.',
                'attributes' => ['Test1', 'Test2'],
                'price' => 'X',
                'unit' => 'RON',
            ],
            'copywriting' => [
                'originalKey' => 'copywriting',
                'title' => 'Copywriting',
                'body1' => 'Copywritingul este arta și știința de a crea conținut scris persuasiv și captivant, cu scopul de a influența cititorii să ia acțiuni specifice, cum ar fi cumpărarea unui produs, completarea unui formular sau înscrierea într-o listă de e-mailuri.',
                'body2' => 'Copywritingul eficient este esențial în publicitate, marketing și comunicare în mediul online și offline, contribuind la succesul campaniilor și la construirea convingătoare a mesajelor de brand.',
                'attributes' => ['Test1', 'Test2'],
                'price' => 'X',
                'unit' => 'RON',
            ],
            'materiale_promotionale' => [
                'originalKey' => 'materiale_promotionale',
                'title' => 'Materiale Promotionale',
                'body1' => 'Materialele promotionale reprezintă instrumente esențiale în strategiile de marketing și branding ale unei afaceri. Acestea includ o gamă variată de obiecte precum tricouri personalizate, pixuri cu logo, broșuri, căni, magneti de frigider și multe altele, fiecare personalizate cu identitatea vizuală a companiei.',
                'body2' => 'Aceste materiale nu numai că oferă o modalitate tangibilă de a-și promova brandul, dar pot și să servească ca amintiri utile pentru clienți și parteneri. Materialele promotionale sunt versatile și pot fi folosite în diverse contexte, de la evenimente corporative și târguri, până la campanii de marketing direct și cadouri de afaceri. Ele contribuie la consolidarea memorabilității brandului și la creșterea loialității clienților, oferind în același timp oportunități de promovare la nivel larg.',
                'attributes' => ['Test1', 'Test2'],
                'price' => 'X',
                'unit' => 'RON',
            ],
        ];

        if (!array_key_exists($key, $individuals)) {
            return $this->redirectToRoute('landing');
        }

        return $this->render('home/individual/generic.html.twig', [
            'context' => $individuals[$key],
        ]);
    }
}