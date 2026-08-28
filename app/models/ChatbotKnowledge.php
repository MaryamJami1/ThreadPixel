<?php
class ChatbotKnowledge extends Model {
    protected $table = 'chatbot_knowledge';

    public static function defaults() {
        return [
            ['General', 'hello hi hey help start', 'How can I help with your ThreadPixel project? I can answer questions about services, pricing, file formats, turnaround, artwork preparation, revisions, orders, and quotes.'],
            ['General', 'what is threadpixel about company business', 'ThreadPixel is a professional embroidery digitizing and vector art studio. We turn artwork, logos, and ideas into clean files ready for embroidery production.'],
            ['General', 'what is embroidery digitizing digitize', 'Embroidery digitizing converts artwork into stitch instructions that an embroidery machine can read. We plan stitch direction, underlay, density, pull compensation, color changes, and trims for a clean result.'],
            ['General', 'human digitizer automatic software quality', 'Every design is reviewed by an experienced human digitizer. We do not rely on auto-digitizing software for your final production file.'],
            ['Services', 'services offer provide available', 'ThreadPixel offers Logo Digitizing, Cap Digitizing, 3D Puff Digitizing, and custom embroidery digitizing. Contact us for appliqué, small text, patches, jacket backs, or specialized requirements.'],
            ['Services', 'logo digitizing logos', 'Logo digitizing converts your brand mark into a clean embroidery file with accurate shapes, stitch direction, density, and color planning.'],
            ['Services', 'cap hat digitizing hats caps', 'Cap digitizing is optimized for curved surfaces, including underlay and stitch sequencing designed for snapbacks, dad hats, trucker caps, beanies, and other headwear.'],
            ['Services', '3d puff raised foam embroidery', '3D Puff Digitizing creates raised embroidery, especially for caps and bold lettering. The design is planned for foam coverage, clean edges, and reliable production.'],
            ['Services', 'vector art redraw vectorize tracing', 'Vector art service redraws or cleans artwork into scalable vector artwork suitable for printing, branding, cutting, and future design use.'],
            ['Services', 'patch digitizing custom patch', 'Patch digitizing prepares artwork for embroidered patches with strong borders, suitable stitch density, and production-ready machine files.'],
            ['Services', 'small text lettering details', 'Small text requires careful font choice, spacing, and stitch planning. Send the target size and fabric so we can recommend the most reliable approach.'],
            ['Pricing', 'price pricing cost charge expensive cheap', 'Pricing depends on design complexity, stitch count, size, fabric or garment type, color changes, and turnaround. Simple logo digitizing starts from $10, but the quote form gives the most accurate price.'],
            ['Pricing', 'quote estimate exact price how much', 'Upload your artwork through the quote form with the size, garment, machine format, quantity, and deadline. We review the design and send a clear quote before work begins.'],
            ['Files', 'formats file type dst pes exp jef vp3 hus xxx', 'We support common embroidery formats including DST, PES, EXP, JEF, VP3, HUS, and XXX. Select your required format in the quote form and tell us if you need another format.'],
            ['Files', 'artwork upload image pdf ai eps psd svg png jpg', 'You can submit PNG, JPG, PDF, AI, EPS, PSD, SVG, and other common artwork formats. Vector artwork is helpful but not required; send the clearest version you have.'],
            ['Files', 'machine compatibility embroidery machine', 'We prepare files for common embroidery machines and formats. Include your machine brand or required format in the quote so we can deliver the correct file.'],
            ['Turnaround', 'turnaround delivery time fast rush urgent deadline', 'Standard turnaround is usually 12–24 hours after the project details are approved. Rush service may be available depending on complexity and workload, so include your deadline in the quote.'],
            ['Process', 'how works steps process order', 'The process is simple: send your design, receive a review and quote, approve the project, let our digitizer build and quality-check the file, then download the final files securely.'],
            ['Process', 'quality check test production stitch out', 'We review stitch paths, density, underlay, trims, color changes, and machine compatibility before delivery. Tell us about your fabric or production setup for more targeted preparation.'],
            ['Revisions', 'revision change edit fix correction not satisfied', 'Minor revisions are included. If the result needs adjustment, send clear feedback or a sew-out photo and we will refine the file for the intended production result.'],
            ['Orders', 'order status dashboard download files account', 'Create an account to manage quotes, orders, messages, and delivered files from your dashboard. After approval, final files are delivered securely through your account.'],
            ['Payment', 'pay payment invoice', 'A final quote is provided before work begins. For payment details or an invoice, contact the ThreadPixel team through the contact page after receiving your quote.'],
            ['Support', 'contact human email support talk person', 'You can reach the ThreadPixel team through the Contact page. Include your artwork, order or quote number, and the question so we can respond quickly.'],
            ['Artwork', 'prepare design fabric size colors thread', 'For the best quote, provide the artwork, finished size, garment or fabric, target machine format, thread color preferences, quantity, and deadline.'],
            ['International', 'worldwide countries international global', 'ThreadPixel serves brands, embroidery shops, businesses, and creators internationally. We work with clients across different time zones and support common machine formats worldwide.'],
            ['Portfolio', 'portfolio work examples designs gallery', 'Visit the Portfolio page to see examples of embroidery digitizing work and compare original artwork with digitized previews where available.'],
            ['Account', 'register login forgot password customer', 'You can create an account to submit and track quotes, manage orders, message the team, and access delivered files. Use the Login or Create Account links in the navigation.']
        ];
    }

    public function seedDefaults() {
        if ($this->getCount() > 0) {
            return;
        }

        $stmt = $this->db->prepare('INSERT INTO chatbot_knowledge (category, keywords, question, answer, is_active) VALUES (:category, :keywords, :question, :answer, 1)');
        foreach (self::defaults() as $entry) {
            $stmt->execute([
                'category' => $entry[0],
                'keywords' => $entry[1],
                'question' => $entry[1],
                'answer' => $entry[2]
            ]);
        }
    }

    public function search($query) {
        $this->seedDefaults();
        $query = strtolower(trim($query));
        $stopWords = ['the', 'and', 'for', 'are', 'can', 'you', 'how', 'what', 'does', 'with', 'from', 'your', 'need', 'about', 'is', 'to', 'do', 'i'];
        $words = array_values(array_filter(preg_split('/[^a-z0-9]+/', $query), function ($word) use ($stopWords) {
            return strlen($word) > 2 && !in_array($word, $stopWords, true);
        }));

        // Build keyword search
        $conditions = [];
        $params = [];
        foreach ($words as $i => $word) {
            if (strlen($word) > 2) {
                $conditions[] = "(LOWER(keywords) LIKE :w{$i} OR LOWER(question) LIKE :q{$i})";
                $params["w{$i}"] = "%{$word}%";
                $params["q{$i}"] = "%{$word}%";
            }
        }

        if (empty($conditions)) {
            return null;
        }

        $sql = "SELECT *, (" . implode(' + ', array_map(function($c) { return "CASE WHEN {$c} THEN 1 ELSE 0 END"; }, $conditions)) . ") as relevance FROM chatbot_knowledge WHERE is_active = 1 AND (" . implode(' OR ', $conditions) . ") ORDER BY relevance DESC, id ASC LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function getActive() {
        $this->seedDefaults();
        $stmt = $this->db->query("SELECT * FROM chatbot_knowledge WHERE is_active = 1 ORDER BY category ASC");
        return $stmt->fetchAll();
    }

    public function toggleActive($id) {
        $stmt = $this->db->prepare("UPDATE chatbot_knowledge SET is_active = NOT is_active WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
