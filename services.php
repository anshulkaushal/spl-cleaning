<?php
/**
 * Services Page
 */

$pageTitle = 'Our Services';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/models/Service.php';

$serviceModel = new Service();
$services = $serviceModel->getAll();

function service_slug($name) {
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', trim($name)));
    return trim($slug, '-');
}

$detailBlocks = [
    'Commercial Cleaning' => [
        'Comprehensive daily, weekly or fortnightly programmes tailored to foot traffic and compliance requirements.',
        'Colour-coded equipment, eco-certified chemicals and full security vetting for every operative.',
        'Available after-hours or overnight to keep workplaces disruption-free.'
    ],
    'Carpet Cleaning' => [
        'Steam extraction and low-moisture options suited to wool, synthetic and blended fibres.',
        'Rapid dry times using industrial air movers—ideal for offices and rental turnovers.',
        'Targeted stain and odour treatments that are child and pet safe.'
    ],
    'Upholstery Cleaning' => [
        'Delicate fabric assessment prior to clean to ensure colour-fast results.',
        'Encapsulation technology lifts dirt, skin oils and allergens without over-wetting.',
        'Protective finishing options to prolong the life of furniture assets.'
    ],
    'End of Tenancy Cleaning' => [
        'Checklist aligned with local property managers, including oven detailing and window tracks.',
        'Optional carpet, pest and lawn add-ons for a move-out done in one visit.',
        'Photo documentation supplied for landlords and letting agents.'
    ],
    'Builders Cleaning' => [
        'Multi-stage dust extraction covering ceilings, frames, glazing and hard surfaces.',
        'High-access cleaning, adhesive removal and final presentation polishing.',
        'Site-safe inducted teams with PPE, RAMS documentation and tool tagging.'
    ],
    'Pressure Washing' => [
        'Adjustable pressure systems to safely treat cladding, decking, concrete and pavers.',
        'Mould, lichen and algae treatments that keep exterior surfaces fresher for longer.',
        'Pre-clean water reclaim options for commercial compliance.'
    ],
    'Gutter Cleaning' => [
        'Vacuum or manual clearing of gutters, valleys and downpipes with debris removed offsite.',
        'Camera inspections to verify flow and highlight any maintenance concerns.',
        'Ideal pre-winter service to prevent roofing and drainage damage.'
    ],
    'Lawn Mowing' => [
        'Precision mowing, edging and clean-up for residential, commercial and lifestyle blocks.',
        'Seasonal fertilising, weed control and hedging packages available.',
        'Flexible maintenance schedules to keep outdoor areas presentation-ready.'
    ]
];
?>

<div class="container py-5">
    <div class="text-center mb-5">
        <span class="section-heading">Service catalogue</span>
        <h1 class="display-5 fw-bold">All your cleaning & exterior care, handled by one skilled team</h1>
        <p class="lead">Choose a single service or combine multiple solutions for a streamlined, cost-effective maintenance plan.</p>
    </div>

    <div class="row g-4">
        <?php foreach ($services as $service): ?>
        <?php $slug = service_slug($service['name']); ?>
        <div class="col-lg-6" id="service-<?php echo $slug; ?>">
            <div class="card h-100">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle"><i class="bi bi-<?php echo htmlspecialchars($service['icon'] ?? 'sparkles'); ?>"></i></div>
                            <div>
                                <h3 class="h4 fw-bold mb-1"><?php echo htmlspecialchars($service['name']); ?></h3>
                                <p class="text-secondary mb-0"><?php echo htmlspecialchars($service['description']); ?></p>
                            </div>
                        </div>
                        <?php if ($service['base_price']): ?>
                            <span class="pill mt-3 mt-md-0">From $<?php echo number_format($service['base_price'], 2); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($detailBlocks[$service['name']])): ?>
                    <ul class="list-unstyled d-grid gap-2 mb-4">
                        <?php foreach ($detailBlocks[$service['name']] as $bullet): ?>
                        <li><i class="bi bi-check-circle text-accent"></i> <?php echo htmlspecialchars($bullet); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="/request-quote?service=<?php echo $service['id']; ?>" class="btn btn-primary"><i class="bi bi-journal-text"></i> Book this service</a>
                        <a href="/request-quote" class="btn btn-outline-primary"><i class="bi bi-ui-checks"></i> Combine with other services</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row g-4 mt-5">
        <div class="col-lg-4">
            <div class="highlight-card h-100">
                <h4 class="fw-bold mb-3">Tailored service plans</h4>
                <p>Create a maintenance bundle that suits your property portfolio or multi-site business.</p>
                <ul class="list-unstyled d-grid gap-2 mb-4">
                    <li><i class="bi bi-arrow-right-circle text-accent"></i> Flexible scheduling (daily, weekly, fortnightly)</li>
                    <li><i class="bi bi-arrow-right-circle text-accent"></i> Dedicated supervisors for commercial accounts</li>
                    <li><i class="bi bi-arrow-right-circle text-accent"></i> Consolidated reporting and invoicing</li>
                </ul>
                <a href="/request-quote" class="btn btn-primary"><i class="bi bi-clipboard-data"></i> Request a proposal</a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="highlight-card h-100">
                <h4 class="fw-bold mb-3">Quality & safety assured</h4>
                <p>We operate with comprehensive policies covering health and safety, environmental care and security.</p>
                <ul class="list-unstyled d-grid gap-2 mb-0">
                    <li><i class="bi bi-shield-lock text-accent"></i> Site inductions and hazard management plans</li>
                    <li><i class="bi bi-recycle text-accent"></i> Sustainable chemical selection and waste control</li>
                    <li><i class="bi bi-patch-check text-accent"></i> Public liability insurance and police-vetted staff</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="highlight-card h-100">
                <h4 class="fw-bold mb-3">Need something unique?</h4>
                <p>Talk to us about specialist cleans including event clean-ups, high-access glass or flood remediation.</p>
                <div class="contact-tile mt-4">
                    <strong>Book a consult</strong>
                    <span><i class="bi bi-telephone"></i> +64 210 258 8777</span>
                    <span><i class="bi bi-envelope"></i> hello@sparklepro.co.nz</span>
                    <a href="/request-quote" class="btn btn-accent align-self-start"><i class="bi bi-chat-dots"></i> Speak to a specialist</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

