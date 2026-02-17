#!/bin/bash
# Fake sendmail para desarrollo - guarda los emails en archivos
# en lugar de enviarlos realmente

MAILDIR="/var/www/html/tmp/emails"
mkdir -p "$MAILDIR"

# Generar nombre único para el email
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
RANDOM_ID=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 8 | head -n 1)
FILENAME="${MAILDIR}/email_${TIMESTAMP}_${RANDOM_ID}.eml"

# Leer el email desde stdin y guardarlo
cat > "$FILENAME"

# Registrar en log
echo "[$(date)] Email guardado en: $FILENAME" >> "${MAILDIR}/sendmail.log"

# Simular éxito
exit 0
