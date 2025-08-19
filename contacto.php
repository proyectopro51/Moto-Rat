<!-- Cambiar el primer formulario a: -->
<form class="contact-form" id="contactForm" method="POST" action="includes/procesar_contacto.php">
  <div class="form-row">
    <div class="form-group">
      <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
    </div>
    <div class="form-group">
      <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>
  </div>
  <div class="form-group">
    <input type="text" name="asunto" class="form-control" placeholder="Asunto">
  </div>
  <div class="form-group">
    <textarea name="mensaje" class="form-control" placeholder="Tu mensaje" required></textarea>
  </div>
  <button class="btn btn-primary" type="submit">Enviar Mensaje</button>
  <div id="formFeedback" style="margin-top: 16px; display: none;"></div>
</form>

<!-- Cambiar el segundo formulario a: -->
<form id="creditoForm" method="POST" action="includes/procesar_credito.php" style="max-width: 640px; margin-top: 24px;">
  <div class="form-row">
    <div class="form-group">
      <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre completo" required>
    </div>
    <div class="form-group">
      <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group">
      <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" required>
    </div>
    <div class="form-group">
      <input type="number" name="monto_solicitado" class="form-control" placeholder="Monto solicitado" required step="0.01">
    </div>
  </div>
  
  <div class="form-group">
    <select name="producto_interes" class="form-control" required>
      <option value="" disabled selected>Selecciona un producto de interés</option>
      <option value="Moto deportiva">Moto deportiva</option>
      <option value="Accesorios">Accesorios</option>
      <option value="Refacciones">Refacciones</option>
      <option value="Equipo de protección">Equipo de protección</option>
    </select>
  </div>
  
  <button class="btn btn-primary" type="submit">Solicitar Crédito</button>
  <div id="creditoFeedback" style="margin-top: 16px; display: none;"></div>
</form>
