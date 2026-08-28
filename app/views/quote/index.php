<div class="container py-5">
    <div style="max-width: 800px; margin: 0 auto; background-color: var(--secondary-bg); padding: 3rem; border-radius: 12px; border: 1px solid var(--border-color);">
        <div class="text-center mb-4">
            <h1 style="color: var(--accent-blue);">Ready to Turn Your Artwork Into Stitches?</h1>
            <p style="color: var(--gray-text);">Upload your design requirements to get a professional digitizing quote.</p>
        </div>

        <form action="<?= BASE_URL ?>/quote/store" method="POST" enctype="multipart/form-data">
            <?= CSRF::getTokenField() ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Personal Info -->
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= Session::userName() ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control" value="<?= Session::userId() ? Session::get('user_email') : '' ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Business Name (Optional)</label>
                    <input type="text" name="business_name" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control">
                </div>

                <!-- Project Info -->
                <div class="form-group">
                    <label class="form-label">Service Type *</label>
                    <select name="service_id" class="form-control" required>
                        <option value="">Select a service...</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= $service->id ?>" <?= isset($_GET['service']) && $_GET['service'] == $service->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($service->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Required Machine Format</label>
                    <select name="machine_format" class="form-control">
                        <option value="DST">DST (Tajima)</option>
                        <option value="PES">PES (Brother, Deco, Babylock)</option>
                        <option value="EXP">EXP (Melco, Bernina)</option>
                        <option value="JEF">JEF (Janome, Elna, Kenmore)</option>
                        <option value="VP3">VP3 (Husqvarna, Pfaff)</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Garment Type</label>
                    <input type="text" name="garment_type" class="form-control" placeholder="e.g. Cotton Polo, Denim Jacket, 6-Panel Cap">
                </div>
                <div class="form-group">
                    <label class="form-label">Design Size</label>
                    <input type="text" name="design_size" class="form-control" placeholder="e.g. 3.5 inches wide">
                </div>
            </div>

            <div class="form-group mt-4">
                <label class="form-label">Additional Instructions</label>
                <textarea name="additional_instructions" class="form-control" rows="4" placeholder="Any specific thread colors, trims, or density requirements?"></textarea>
            </div>

            <!-- Interactive File Upload resembling an embroidery hoop concept visually -->
            <div class="form-group mt-4 text-center" style="padding: 3rem; border: 2px dashed var(--accent-blue); border-radius: 50%; width: 250px; height: 250px; margin: 0 auto; display: flex; flex-direction: column; justify-content: center; position: relative;">
                <input type="file" name="artwork[]" id="artwork" class="form-control" style="opacity: 0; position: absolute; top:0; left:0; width:100%; height:100%; cursor: pointer;" multiple required>
                <label class="custom-file-label" style="pointer-events: none; color: var(--primary-text); font-weight: 600;">
                    Click to Upload Artwork<br>
                    <span style="font-size: 0.8rem; color: var(--gray-text); font-weight: 400;">PNG, JPG, PDF, AI, SVG</span>
                </label>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_rush" value="1">
                    <span style="color: var(--warning); font-weight: 600;">Rush Order (24h delivery)</span>
                </label>
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem; font-size: 1.1rem;">Get My Quote</button>
            </div>
        </form>
    </div>
</div>
