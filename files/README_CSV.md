# Archivos CSV para Testing con Katalon

Este conjunto de archivos CSV contiene datos de prueba para diferentes escenarios de testing de la tienda TechStore.

## 📋 Archivos Incluidos

### 1. datos_prueba_checkout.csv
**Propósito**: Datos completos para probar el formulario de checkout

**Columnas**:
- `nombre_completo`: Nombre del cliente
- `email`: Correo electrónico
- `telefono`: Número de teléfono
- `direccion`: Dirección de envío
- `ciudad`: Ciudad
- `codigo_postal`: Código postal
- `metodo_pago`: Método de pago seleccionado
- `numero_tarjeta`: Número de tarjeta (para pruebas)
- `fecha_expiracion`: Fecha de expiración (MM/AA)
- `cvv`: Código CVV
- `aceptar_terminos`: Si acepta términos (true/false)

**Registros**: 25 usuarios con datos variados
**Casos especiales**: 
- Registro #21 tiene `aceptar_terminos=false` para probar validación
- Diferentes métodos de pago
- Tarjetas con diferentes fechas de expiración

### 2. datos_productos_carrito.csv
**Propósito**: Datos para agregar productos al carrito en diferentes escenarios

**Columnas**:
- `producto_id`: ID del producto (1-8)
- `nombre_producto`: Nombre descriptivo
- `cantidad`: Cantidad a agregar
- `escenario`: Tipo de prueba

**Escenarios incluidos**:
- `compra_simple`: Un producto con cantidad 1
- `compra_multiple`: Varios productos con diferentes cantidades
- `compra_combo`: Combinación de productos
- `compra_cantidad_alta`: Productos con cantidades altas
- `stock_limite`: Para probar límites de stock
- `producto_economico`: Productos de bajo precio
- `producto_premium`: Productos de alto precio

### 3. datos_contacto.csv
**Propósito**: Datos para probar el formulario de contacto

**Columnas**:
- `nombre`: Nombre del contacto
- `email`: Email del contacto
- `asunto`: Asunto del mensaje
- `mensaje`: Contenido del mensaje
- `tipo_consulta`: Categoría de la consulta

**Registros**: 20 consultas diferentes
**Tipos de consulta**: producto, soporte, devolucion, envio, garantia, tecnica, pago, facturacion, cambio, promocion, stock, compatibilidad, horario, internacional, cancelacion, recomendacion, error_web, precio, servicio, comparacion

### 4. datos_prueba_negativos.csv
**Propósito**: Casos de prueba negativos para validaciones

**Columnas**: Mismas que checkout pero con el campo `esperado` y `tipo_error`

**Casos incluidos**:
- Campos obligatorios vacíos
- Formatos inválidos (email, teléfono, código postal)
- Intentos de inyección SQL
- Intentos de XSS
- Nombres muy largos
- Todos los campos vacíos
- Un caso válido para comparación

**Registros**: 15 casos de error + 2 casos válidos

### 5. datos_login.csv
**Propósito**: Datos para pruebas de autenticación (futuro uso)

**Columnas**:
- `username`: Usuario/email
- `password`: Contraseña
- `rol`: Rol del usuario
- `estado`: Estado de la cuenta
- `resultado_esperado`: Resultado esperado de la prueba

**Registros**: 16 casos incluyendo éxito y errores
**Roles**: administrador, usuario, invitado, gerente, soporte
**Estados**: activo, inactivo, pendiente

## 🎯 Cómo Usar en Katalon Studio

### Opción 1: Data Files
1. En Katalon Studio, ve a **Test Data**
2. Click derecho → **New** → **Test Data**
3. Selecciona **Data Type: CSV File**
4. Importa el archivo CSV correspondiente

### Opción 2: Data-Driven Testing
```groovy
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI

// Ejemplo para checkout
WebUI.openBrowser('http://localhost:8000/checkout.php')

def data = findTestData('Data Files/datos_prueba_checkout')

for (int i = 1; i <= data.getRowNumbers(); i++) {
    WebUI.setText(findTestObject('Page_Checkout/input_nombre'), 
        data.getValue('nombre_completo', i))
    WebUI.setText(findTestObject('Page_Checkout/input_email'), 
        data.getValue('email', i))
    // ... más campos
    WebUI.click(findTestObject('Page_Checkout/btn_finalizar'))
    
    // Verificar resultado
    WebUI.verifyElementPresent(findTestObject('Page_Confirmacion/titulo'), 5)
}
```

### Opción 3: Desde Script Groovy
```groovy
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData

def testData = findTestData('datos_prueba_checkout')
def row = testData.getValue('nombre_completo', 1)
```

## 📊 Mapeo de Campos a IDs del HTML

### Formulario Checkout
| Campo CSV | ID HTML | Tipo |
|-----------|---------|------|
| nombre_completo | #nombre | text |
| email | #email | email |
| telefono | #telefono | tel |
| direccion | #direccion | text |
| ciudad | #ciudad | text |
| codigo_postal | #codigo_postal | text |
| metodo_pago | name="metodo_pago" | radio |
| numero_tarjeta | #numero_tarjeta | text |
| fecha_expiracion | #fecha_expiracion | text |
| cvv | #cvv | text |
| aceptar_terminos | #terminos | checkbox |

### Formulario Contacto
| Campo CSV | ID HTML | Tipo |
|-----------|---------|------|
| nombre | #nombre-contacto | text |
| email | #email-contacto | email |
| asunto | #asunto | text |
| mensaje | #mensaje | textarea |

### Agregar al Carrito
| Campo CSV | Uso |
|-----------|-----|
| producto_id | Seleccionar producto en página |
| cantidad | Valor para input.cantidad-input |

## 🔍 Casos de Prueba Sugeridos

### Test Suite 1: Checkout Completo
1. Iterar por `datos_prueba_checkout.csv`
2. Agregar productos al carrito
3. Llenar formulario con datos del CSV
4. Verificar página de confirmación
5. Verificar número de pedido

### Test Suite 2: Validaciones Negativas
1. Usar `datos_prueba_negativos.csv`
2. Para cada registro con ERROR esperado:
   - Intentar enviar formulario
   - Verificar que muestre mensaje de error
   - Verificar que no procese la compra

### Test Suite 3: Flujo de Contacto
1. Iterar por `datos_contacto.csv`
2. Llenar formulario de contacto
3. Enviar
4. Verificar mensaje de éxito

### Test Suite 4: Carrito Múltiple
1. Filtrar `datos_productos_carrito.csv` por escenario
2. Agregar todos los productos del escenario
3. Verificar total calculado
4. Proceder al checkout

## 💡 Tips para Katalon

### Leer valor específico
```groovy
def valor = testData.getValue('nombre_completo', numeroFila)
```

### Contar filas
```groovy
def totalFilas = testData.getRowNumbers()
```

### Filtrar por condición
```groovy
for (int i = 1; i <= data.getRowNumbers(); i++) {
    if (data.getValue('escenario', i) == 'compra_simple') {
        // Ejecutar prueba
    }
}
```

### Parametrizar Test Cases
1. Crear Test Case con variables
2. Hacer bind de variables a columnas del CSV
3. Ejecutar con Test Suite

## 🚨 Notas Importantes

1. **Números de Tarjeta**: Son números de prueba generados aleatoriamente. No uses tarjetas reales.

2. **Datos Personales**: Todos los datos son ficticios y generados para pruebas.

3. **Validaciones**: El sitio web NO valida realmente los números de tarjeta, solo verifica que los campos no estén vacíos.

4. **Encoding**: Los archivos están en UTF-8 con caracteres especiales españoles (tildes, ñ).

5. **Sesiones PHP**: Recuerda que cada sesión mantiene su propio carrito. Usa `WebUI.deleteAllCookies()` entre pruebas si es necesario.

## 📝 Ejemplo Completo de Test Case

```groovy
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData

// Abrir navegador
WebUI.openBrowser('http://localhost:8000')

// Agregar producto al carrito
WebUI.click(findTestObject('Page_Index/btn_agregar_producto_1'))

// Ir al carrito
WebUI.click(findTestObject('Page_Header/nav_carrito'))

// Verificar que el producto está en el carrito
WebUI.verifyElementPresent(findTestObject('Page_Carrito/tabla_carrito'), 5)

// Ir a checkout
WebUI.click(findTestObject('Page_Carrito/btn_checkout'))

// Cargar datos de prueba
def testData = findTestData('datos_prueba_checkout')

// Llenar formulario con primera fila de datos
WebUI.setText(findTestObject('Page_Checkout/input_nombre'), 
    testData.getValue('nombre_completo', 1))
WebUI.setText(findTestObject('Page_Checkout/input_email'), 
    testData.getValue('email', 1))
WebUI.setText(findTestObject('Page_Checkout/input_telefono'), 
    testData.getValue('telefono', 1))
WebUI.setText(findTestObject('Page_Checkout/input_direccion'), 
    testData.getValue('direccion', 1))
WebUI.setText(findTestObject('Page_Checkout/input_ciudad'), 
    testData.getValue('ciudad', 1))
WebUI.setText(findTestObject('Page_Checkout/input_codigo_postal'), 
    testData.getValue('codigo_postal', 1))

// Seleccionar método de pago
def metodoPago = testData.getValue('metodo_pago', 1)
if (metodoPago == 'PayPal') {
    WebUI.click(findTestObject('Page_Checkout/radio_paypal'))
} else {
    WebUI.click(findTestObject('Page_Checkout/radio_tarjeta'))
}

// Aceptar términos
WebUI.check(findTestObject('Page_Checkout/checkbox_terminos'))

// Finalizar compra
WebUI.click(findTestObject('Page_Checkout/btn_finalizar'))

// Verificar página de confirmación
WebUI.verifyElementPresent(findTestObject('Page_Confirmacion/titulo_confirmacion'), 10)
WebUI.verifyElementPresent(findTestObject('Page_Confirmacion/numero_pedido'), 5)

// Cerrar navegador
WebUI.closeBrowser()
```

## 🎓 Recursos Adicionales

- [Documentación Katalon - Data-Driven Testing](https://docs.katalon.com/katalon-studio/docs/ddt.html)
- [Tutorial CSV en Katalon](https://docs.katalon.com/katalon-studio/docs/manage-test-data.html)
- Proyecto TechStore: Revisar README.md de la tienda

---

¿Necesitas más datos o casos de prueba específicos? Puedes modificar estos CSVs según tus necesidades.
