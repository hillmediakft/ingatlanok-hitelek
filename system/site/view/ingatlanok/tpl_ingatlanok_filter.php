<div class="listing__param">
    <?php if (isset($this->filter['tipus'])) : ?>  
        <span class="listing__param-item">
            <span class="label label-default"><?php echo $this->filter['tipus']; ?></span>
        </span>
    <?php endif ?> 
    <?php if (isset($this->filter['kategoria'])) : ?>    
        <span class="listing__param-item">
            <?php foreach ($this->filter['kategoria'] as $value) : ?>
                <span class="label label-default"><?php echo $value; ?></span>
            <?php endforeach ?>
        </span>
    <?php endif ?>
    <?php if (isset($this->filter['varos']) OR isset($this->filter['kerulet'])) : ?>
        <span class="listing__param-item">
            <?php if (isset($this->filter['varos'])) : ?>
                <?php foreach ($this->filter['varos'] as $value) : ?>
                    <span class="label label-default"><?php echo $value; ?></span>
                <?php endforeach ?>
            <?php endif ?>
            <?php if (isset($this->filter['kerulet'])) : ?>        
                <?php foreach ($this->filter['kerulet'] as $value) : ?>
                    <span class="label label-default"><?php echo $value; ?></span>
                <?php endforeach ?>
            <?php endif ?>
        </span>
    <?php endif ?>
    <?php if (isset($this->filter['min_ar']) OR isset($this->filter['max_ar'])) : ?>
        <span class="listing__param-item">
            <?php if ($this->filter['min_ar'] > 0 && $this->filter['max_ar'] < 50000000) : ?>
                <span class="label label-default"><?php echo $this->filter['min_ar'] . '-' . $this->filter['max_ar'] . ' Ft'; ?></span>
            <?php endif ?>
            <?php if ($this->filter['min_ar'] == 0 && $this->filter['max_ar'] < 50000000) : ?>        
                <span class="label label-default"><?php echo $this->filter['max_ar'] . ' Ft-ig'; ?></span>
            <?php endif ?>
            <?php if ($this->filter['min_ar'] == 0 && $this->filter['max_ar'] == 50000000) : ?>        
                <span class="label label-default"><?php echo 'Ár: mindegy'; ?></span>
            <?php endif ?>
        </span>
    <?php endif ?>
    <?php if (isset($this->filter['min_alapterulet']) OR isset($this->filter['max_alapterulet'])) : ?>
        <span class="listing__param-item">
            <?php if ($this->filter['min_alapterulet'] > 0 && $this->filter['max_alapterulet'] < 200) : ?>
                <span class="label label-default"><?php echo 'Alapterület: ' . $this->filter['min_alapterulet'] . '-' . $this->filter['max_alapterulet'] . ' m2'; ?></span>
            <?php endif ?>
            <?php if ($this->filter['min_alapterulet'] == 0 && $this->filter['max_alapterulet'] < 200) : ?>        
                <span class="label label-default"><?php echo 'Alapterület: ' . $this->filter['max_alapterulet'] . ' m2-ig'; ?></span>
            <?php endif ?>
            <?php if ($this->filter['min_alapterulet'] == 0 && $this->filter['max_alapterulet'] == 200) : ?>        
                <span class="label label-default"><?php echo 'Alapterület: mindegy'; ?></span>
            <?php endif ?>
        </span>
    <?php endif ?>
    <?php if (isset($this->filter['min_szobaszam']) OR isset($this->filter['max_szobaszam'])) : ?>
        <span class="listing__param-item">
            <?php if ($this->filter['min_szobaszam'] > 0) : ?>
                <span class="label label-default"><?php echo 'Szobák száma: ' . $this->filter['min_szobaszam'] . '-' . $this->filter['max_szobaszam']; ?></span>
            <?php endif ?>
            <?php if ($this->filter['min_szobaszam'] == 0) : ?>        

                <span class="label label-default"><?php echo 'Szobák száma: max. ' . $this->filter['max_szobaszam']; ?></span>

            <?php endif ?>
        </span>
    <?php endif ?>

</div>

