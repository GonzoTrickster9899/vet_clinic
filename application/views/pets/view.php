<div class="card">
    <h2>🐾 Pet Details</h2>
    <a href="<?= base_url('pets') ?>" class="btn" style="margin-bottom: 20px;">← Back to Pets</a>
    <a href="<?= base_url('pets/edit/' . $pet['id']) ?>" class="btn" style="margin-bottom: 20px;">Edit Pet</a>
    
    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 30px; margin-top: 20px;">
        <div>
            <?php 
            $image_url = isset($pet['image']) && !empty($pet['image']) 
                ? base_url('assets/images/pets/' . $pet['image']) 
                : base_url('assets/images/pets/default-pet.png');
            ?>
            <img src="<?= $image_url ?>" alt="<?= $pet['name'] ?>" 
                 style="width: 100%; border-radius: 12px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"
                 onerror="this.src='<?= base_url('assets/images/pets/default-pet.png') ?>'">
        </div>
        
        <div>
            <h3 style="margin-bottom: 20px; color: #2c3e50;"><?= $pet['name'] ?></h3>
            
            <table style="width: 100%;">
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">ID:</td>
                    <td><?= $pet['id'] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Species:</td>
                    <td><?= $pet['species'] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Breed:</td>
                    <td><?= $pet['breed'] ?: 'N/A' ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Age:</td>
                    <td><?= $pet['age'] ?> years</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Weight:</td>
                    <td><?= $pet['weight'] ?> kg</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Owner:</td>
                    <td><?= $owner ? $owner['name'] : 'Unknown' ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Owner Contact:</td>
                    <td><?= $owner ? $owner['phone'] : 'N/A' ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 10px 0;">Registered:</td>
                    <td><?= date('F j, Y', strtotime($pet['created_at'])) ?></td>
                </tr>
            </table>
            
            <?php if (!empty($pet['medical_history'])): ?>
            <div style="margin-top: 30px;">
                <h4 style="color: #2c3e50; margin-bottom: 10px;">📋 Medical History</h4>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #3498db;">
                    <?= nl2br($pet['medical_history']) ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>